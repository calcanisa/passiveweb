<?php
defined( 'ABSPATH' ) || exit;

function pw_setup_pages() {
	return array(
		'home'     => array(
			'title'    => 'Home',
			'template' => '',
		),
		'about'    => array(
			'title'    => 'About',
			'template' => 'page-templates/about.php',
		),
		'projects' => array(
			'title'    => 'Projects',
			'template' => 'page-templates/projects.php',
		),
		'process'  => array(
			'title'    => 'Process',
			'template' => 'page-templates/process.php',
		),
		'services' => array(
			'title'    => 'Services',
			'template' => 'page-templates/services.php',
		),
		'contact'  => array(
			'title'    => 'Contact',
			'template' => 'page-templates/contact.php',
		),
	);
}

function pw_seed_first_project() {
	if ( get_option( 'pw_projects_seeded' ) ) {
		return;
	}

	$existing = get_posts(
		array(
			'post_type'      => 'pw_project',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( ! $existing ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'pw_project',
				'post_status'  => 'publish',
				'post_title'   => 'DoBiz',
				'post_excerpt' => 'The South African database, business directory and initiative to help fix South Africa.',
				'post_content' => '',
				'menu_order'   => 0,
			),
			true
		);

		if ( ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_pw_tag', 'Venture' );
			update_post_meta( $id, '_pw_url', 'https://dobiz.co.za' );
			update_post_meta( $id, '_pw_services', 'Web platform, Mobile app, Business directory' );
		}
	}

	update_option( 'pw_projects_seeded', 1, false );
}

function pw_after_switch_theme() {
	if ( ! current_user_can( 'switch_themes' ) ) {
		return;
	}

	pw_register_projects();
	pw_seed_first_project();

	$pages = pw_setup_pages();
	$ids   = array();

	foreach ( $pages as $slug => $page ) {
		$existing = get_page_by_path( $slug, OBJECT, 'page' );

		if ( $existing ) {
			$ids[ $slug ] = (int) $existing->ID;
			if ( $page['template'] && ! get_page_template_slug( $existing->ID ) ) {
				update_post_meta( $existing->ID, '_wp_page_template', $page['template'] );
			}
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $slug,
				'post_content' => '',
			),
			true
		);

		if ( is_wp_error( $id ) ) {
			continue;
		}

		$ids[ $slug ] = (int) $id;

		if ( $page['template'] ) {
			update_post_meta( $id, '_wp_page_template', $page['template'] );
		}
	}

	if ( 'page' !== get_option( 'show_on_front' ) && ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['home'] );
	}

	$locations = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! is_array( $locations ) ) {
		$locations = array();
	}

	$menu = wp_get_nav_menu_object( 'Passive Web Primary' );

	if ( ! $menu ) {
		$menu_id = wp_create_nav_menu( 'Passive Web Primary' );

		if ( ! is_wp_error( $menu_id ) ) {
			$position = 1;
			foreach ( array_keys( $pages ) as $slug ) {
				if ( empty( $ids[ $slug ] ) ) {
					continue;
				}
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'     => $pages[ $slug ]['title'],
						'menu-item-object'    => 'page',
						'menu-item-object-id' => $ids[ $slug ],
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $position++,
					)
				);
			}
			$locations['primary'] = (int) $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	} elseif ( empty( $locations['primary'] ) ) {
		$locations['primary'] = (int) $menu->term_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
add_action( 'after_switch_theme', 'pw_after_switch_theme' );
