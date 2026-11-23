<?php
defined( 'ABSPATH' ) || exit;

function pw_get_icon( $name, $size = 20, $stroke = '1.4' ) {
	$paths = array(
		'pen'         => '<path d="M12 20h9"></path><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>',
		'code'        => '<polyline points="8 6 2 12 8 18"></polyline><polyline points="16 6 22 12 16 18"></polyline>',
		'megaphone'   => '<path d="M3 11v3a1 1 0 0 0 1 1h2l3.5 5V5L6 10H4a1 1 0 0 0-1 1Z"></path><path d="M14 8a4 4 0 0 1 0 8"></path><path d="M17.5 4.5a9 9 0 0 1 0 15"></path>',
		'server'      => '<rect x="3" y="4" width="18" height="6" rx="1.5"></rect><rect x="3" y="14" width="18" height="6" rx="1.5"></rect>',
		'shield'      => '<path d="M12 3 4 6v6c0 4.5 3.2 7.7 8 9 4.8-1.3 8-4.5 8-9V6Z"></path><path d="m9 12 2 2 4-4"></path>',
		'pin'         => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"></path><circle cx="12" cy="10" r="3"></circle>',
		'mail'        => '<rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="m22 6-10 7L2 6"></path>',
		'close'       => '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>',
		'arrow-left'  => '<path d="M19 12H5"></path><path d="m12 19-7-7 7-7"></path>',
		'arrow-right' => '<path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path>',
		'arrow-down'  => '<path d="M12 5v14"></path><path d="m19 12-7 7-7-7"></path>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return sprintf(
		'<svg class="pw-ico" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="%2$s" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%3$s</svg>',
		absint( $size ),
		esc_attr( $stroke ),
		$paths[ $name ]
	);
}

function pw_icon( $name, $size = 20, $stroke = '1.4' ) {
	echo pw_get_icon( $name, $size, $stroke );
}

function pw_logo( $class = 'pw-logo', $width = 140 ) {
	if ( 'pw-logo' === $class && has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	$base   = get_template_directory_uri() . '/assets/img/';
	$width  = absint( $width );
	$height = (int) round( $width * 185 / 560 );

	printf(
		'<a class="%1$s" href="%2$s" rel="home"><img src="%3$s" srcset="%3$s 1x, %4$s 2x" width="%5$d" height="%6$d" alt="%7$s"></a>',
		esc_attr( $class ),
		esc_url( home_url( '/' ) ),
		esc_url( $base . 'logo-280.png' ),
		esc_url( $base . 'logo-560.png' ),
		$width,
		$height,
		esc_attr( get_bloginfo( 'name' ) )
	);
}

function pw_page_url( $slug ) {
	if ( 'home' === $slug ) {
		return home_url( '/' );
	}

	$page = get_page_by_path( $slug, OBJECT, 'page' );

	if ( $page && 'publish' === $page->post_status ) {
		return get_permalink( $page );
	}

	return home_url( '/' . $slug . '/' );
}

function pw_menu_links() {
	return array(
		'home'     => 'Home',
		'about'    => 'About',
		'projects' => 'Projects',
		'process'  => 'Process',
		'services' => 'Services',
		'contact'  => 'Contact',
	);
}

function pw_is_current_slug( $slug ) {
	if ( 'home' === $slug ) {
		return is_front_page();
	}

	$page = get_page_by_path( $slug, OBJECT, 'page' );

	return $page && is_page( $page->ID );
}

function pw_menu_fallback( $args = array() ) {
	echo '<ul class="pw-nav__list">';
	foreach ( pw_menu_links() as $slug => $label ) {
		$current = pw_is_current_slug( $slug );
		printf(
			'<li class="%1$s"><a href="%2$s"%3$s>%4$s</a></li>',
			$current ? 'current-menu-item' : '',
			esc_url( pw_page_url( $slug ) ),
			$current ? ' aria-current="page"' : '',
			esc_html( $label )
		);
	}
	echo '</ul>';
}

function pw_footer_menu_fallback( $args = array() ) {
	echo '<ul class="pw-footer__list">';
	foreach ( pw_menu_links() as $slug => $label ) {
		if ( 'home' === $slug ) {
			continue;
		}
		printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( pw_page_url( $slug ) ), esc_html( $label ) );
	}
	$privacy = get_privacy_policy_url();
	if ( $privacy ) {
		printf( '<li><a href="%1$s">Privacy Policy</a></li>', esc_url( $privacy ) );
	}
	echo '</ul>';
}

function pw_editor_content() {
	if ( '' === trim( (string) get_post_field( 'post_content', get_the_ID() ) ) ) {
		return;
	}
	echo '<section class="pw-section"><div class="pw-wrap pw-prose">';
	the_content();
	echo '</div></section>';
}
