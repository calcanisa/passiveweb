<?php
/*
Template Name: Contact
*/

defined( 'ABSPATH' ) || exit;

get_header();

$pw_status    = isset( $_GET['pw_contact'] ) && is_string( $_GET['pw_contact'] ) ? sanitize_key( wp_unslash( $_GET['pw_contact'] ) ) : '';
$pw_messages  = array(
	'sent'    => array( 'ok', 'Thank you. Your message is on its way and we will be in touch soon.' ),
	'invalid' => array( 'err', 'Please fill in your name, a valid email address and a message.' ),
	'limited' => array( 'err', 'Too many messages from your connection. Please try again later or email us directly.' ),
	'error'   => array( 'err', 'Something went wrong sending your message. Please try again or email us directly.' ),
);
$pw_timestamp = time();

while ( have_posts() ) :
	the_post();
	?>
	<section class="pw-section pw-section--intro">
		<div class="pw-wrap pw-split">
			<div class="pw-split__main pw-split__main--narrow">
				<p class="pw-label">Get in touch</p>
				<h1 class="pw-h1">Let's start a conversation</h1>
				<p class="pw-lead">Tell us about your project or the service you need. You get a written quote, and we beat any other written quote you have.</p>
				<ul class="pw-contact-list">
					<li><?php pw_icon( 'pin', 20, '1.6' ); ?>Pretoria, South Africa</li>
					<li><a href="mailto:hello@passiveweb.co.za"><?php pw_icon( 'mail', 20, '1.6' ); ?>hello@passiveweb.co.za</a></li>
				</ul>
				<div class="pw-promise">
					<strong>100% satisfaction guaranteed.</strong>
					<span>Not happy with the work? The charge is R0.</span>
				</div>
			</div>
			<form id="contact-form" class="pw-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<?php if ( isset( $pw_messages[ $pw_status ] ) ) : ?>
					<div class="pw-notice pw-notice--<?php echo esc_attr( $pw_messages[ $pw_status ][0] ); ?>" role="status"><?php echo esc_html( $pw_messages[ $pw_status ][1] ); ?></div>
				<?php endif; ?>
				<input type="hidden" name="action" value="pw_contact">
				<input type="hidden" name="pw_return" value="<?php echo esc_attr( get_queried_object_id() ); ?>">
				<input type="hidden" name="pw_ts" value="<?php echo esc_attr( $pw_timestamp ); ?>">
				<input type="hidden" name="pw_sig" value="<?php echo esc_attr( pw_contact_sign( $pw_timestamp ) ); ?>">
				<?php wp_nonce_field( 'pw_contact', 'pw_contact_nonce', false ); ?>
				<div class="pw-hp" aria-hidden="true">
					<label>Leave this field empty<input type="text" name="pw_extra_field" value="" tabindex="-1" autocomplete="off"></label>
				</div>
				<div class="pw-form__row">
					<label class="pw-field">Name <span class="pw-req" aria-hidden="true">*</span><input type="text" name="pw_name" autocomplete="name" maxlength="100" required></label>
					<label class="pw-field">Email <span class="pw-req" aria-hidden="true">*</span><input type="email" name="pw_email" autocomplete="email" maxlength="254" required></label>
				</div>
				<div class="pw-form__row">
					<label class="pw-field">Phone<input type="tel" name="pw_phone" autocomplete="tel" maxlength="30"></label>
					<label class="pw-field">Company<input type="text" name="pw_company" autocomplete="organization" maxlength="120"></label>
				</div>
				<label class="pw-field">What do you need?
					<select name="pw_need">
						<?php foreach ( pw_contact_needs() as $pw_need ) : ?>
							<option value="<?php echo esc_attr( $pw_need ); ?>"><?php echo esc_html( $pw_need ); ?></option>
						<?php endforeach; ?>
					</select>
				</label>
				<label class="pw-field">Tell us about it <span class="pw-req" aria-hidden="true">*</span><textarea name="pw_message" rows="5" maxlength="5000" required></textarea></label>
				<button type="submit" class="pw-btn pw-btn--block">Get my quote &rarr;</button>
			</form>
		</div>
	</section>
	<?php
	pw_editor_content();
endwhile;

get_footer();
