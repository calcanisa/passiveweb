<?php
defined( 'ABSPATH' ) || exit;

function pw_contact_needs() {
	return array(
		'A complete project',
		'An individual service',
		'Not sure yet',
	);
}

function pw_contact_sign( $timestamp ) {
	return hash_hmac( 'sha256', 'pw_contact|' . absint( $timestamp ), wp_salt( 'nonce' ) );
}

function pw_contact_client_key() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	return 'pw_contact_' . substr( hash_hmac( 'sha256', $ip, wp_salt( 'auth' ) ), 0, 32 );
}

function pw_contact_redirect( $status ) {
	$return_id = isset( $_POST['pw_return'] ) ? absint( $_POST['pw_return'] ) : 0;
	$url       = '';

	if ( $return_id && 'publish' === get_post_status( $return_id ) && 'page' === get_post_type( $return_id ) ) {
		$url = get_permalink( $return_id );
	}

	if ( ! $url ) {
		$url = home_url( '/' );
	}

	wp_safe_redirect( add_query_arg( 'pw_contact', $status, $url ) . '#contact-form', 303 );
	exit;
}

function pw_contact_field( $key, $max ) {
	if ( ! isset( $_POST[ $key ] ) || ! is_string( $_POST[ $key ] ) ) {
		return '';
	}
	return mb_substr( sanitize_text_field( wp_unslash( $_POST[ $key ] ) ), 0, $max );
}

function pw_handle_contact() {
	if ( ! isset( $_SERVER['REQUEST_METHOD'] ) || 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
		wp_safe_redirect( home_url( '/' ), 303 );
		exit;
	}

	$nonce = isset( $_POST['pw_contact_nonce'] ) && is_string( $_POST['pw_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['pw_contact_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'pw_contact' ) ) {
		pw_contact_redirect( 'error' );
	}

	$timestamp = isset( $_POST['pw_ts'] ) ? absint( $_POST['pw_ts'] ) : 0;
	$signature = isset( $_POST['pw_sig'] ) && is_string( $_POST['pw_sig'] ) ? sanitize_text_field( wp_unslash( $_POST['pw_sig'] ) ) : '';
	$age       = time() - $timestamp;
	if ( ! $timestamp || ! hash_equals( pw_contact_sign( $timestamp ), $signature ) || $age < 3 || $age > DAY_IN_SECONDS ) {
		pw_contact_redirect( 'error' );
	}

	if ( ! empty( $_POST['pw_extra_field'] ) ) {
		pw_contact_redirect( 'sent' );
	}

	$key      = pw_contact_client_key();
	$attempts = (int) get_transient( $key );
	if ( $attempts >= 5 ) {
		pw_contact_redirect( 'limited' );
	}
	set_transient( $key, $attempts + 1, HOUR_IN_SECONDS );

	$name    = pw_contact_field( 'pw_name', 100 );
	$email   = sanitize_email( pw_contact_field( 'pw_email', 254 ) );
	$phone   = preg_replace( '/[^0-9+().\s-]/', '', pw_contact_field( 'pw_phone', 30 ) );
	$company = pw_contact_field( 'pw_company', 120 );
	$need    = pw_contact_field( 'pw_need', 60 );
	$message = isset( $_POST['pw_message'] ) && is_string( $_POST['pw_message'] ) ? mb_substr( sanitize_textarea_field( wp_unslash( $_POST['pw_message'] ) ), 0, 5000 ) : '';

	if ( ! in_array( $need, pw_contact_needs(), true ) ) {
		$need = 'Not sure yet';
	}

	if ( '' === $name || ! is_email( $email ) || '' === trim( $message ) ) {
		pw_contact_redirect( 'invalid' );
	}

	$subject = sprintf( 'New quote request: %1$s from %2$s', $need, $name );

	$body  = "New quote request from the Passive Web website\n\n";
	$body .= 'Name: ' . $name . "\n";
	$body .= 'Email: ' . $email . "\n";
	$body .= 'Phone: ' . ( '' !== $phone ? $phone : 'Not given' ) . "\n";
	$body .= 'Company: ' . ( '' !== $company ? $company : 'Not given' ) . "\n";
	$body .= 'Needs: ' . $need . "\n\n";
	$body .= "Message:\n" . $message . "\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $email,
	);

	$sent = wp_mail( get_option( 'admin_email' ), $subject, $body, $headers );

	pw_contact_redirect( $sent ? 'sent' : 'error' );
}
add_action( 'admin_post_nopriv_pw_contact', 'pw_handle_contact' );
add_action( 'admin_post_pw_contact', 'pw_handle_contact' );
