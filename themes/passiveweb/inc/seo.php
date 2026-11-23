<?php
defined( 'ABSPATH' ) || exit;

function pw_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || class_exists( 'RankMath' );
}

function pw_seo_post_types() {
	return array( 'page', 'post' );
}

function pw_seo_defaults() {
	return array(
		'front'                        => array(
			'title' => 'Passive Web | Project Development, Web Design and Marketing in Pretoria',
			'desc'  => 'Passive Web builds complete websites, web apps and mobile apps in Pretoria, hands them over once everything works, then markets them for fast traffic.',
		),
		'page-templates/about.php'    => array(
			'title' => 'About Passive Web | Project Developers in Pretoria, South Africa',
			'desc'  => 'Passive Web (Pty) Ltd is a Pretoria technology company that takes projects from idea to finished product, hands them over and markets them for growth.',
		),
		'page-templates/projects.php' => array(
			'title' => 'Projects | Websites, Web Apps and Platforms by Passive Web',
			'desc'  => 'See complete projects Passive Web planned, built, launched and handed over, including DoBiz. Scroll through each full site or visit it live.',
		),
		'page-templates/process.php'  => array(
			'title' => 'Our Process | From Idea to Traffic in Six Steps | Passive Web',
			'desc'  => 'How Passive Web works: discover and quote, design, develop, test and launch, hand over the keys, then market your project hard for fast traffic.',
		),
		'page-templates/services.php' => array(
			'title' => 'Services | Web Design, Development, SEO, Hosting and Security in Pretoria',
			'desc'  => 'Design, development, digital marketing, web hosting and cyber security services in Pretoria. We beat any written quote, with 100% satisfaction guaranteed.',
		),
		'page-templates/contact.php'  => array(
			'title' => 'Contact Passive Web | Get a Quote in Pretoria',
			'desc'  => 'Tell Passive Web about your project or the service you need. Get a written quote in Pretoria that beats any other written quote you have.',
		),
	);
}

function pw_seo_default_for( $post_id ) {
	$defaults = pw_seo_defaults();

	if ( (int) get_option( 'page_on_front' ) === (int) $post_id && 'page' === get_option( 'show_on_front' ) ) {
		return $defaults['front'];
	}

	$template = get_page_template_slug( $post_id );

	return isset( $defaults[ $template ] ) ? $defaults[ $template ] : array(
		'title' => '',
		'desc'  => '',
	);
}

function pw_seo_trim( $text, $length = 158 ) {
	$text = trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( strip_shortcodes( (string) $text ) ) ) );
	if ( mb_strlen( $text ) <= $length ) {
		return $text;
	}
	$cut   = mb_substr( $text, 0, $length - 1 );
	$space = mb_strrpos( $cut, ' ' );
	return ( false !== $space ? mb_substr( $cut, 0, $space ) : $cut ) . '.';
}

function pw_seo_context() {
	$context = array(
		'title' => '',
		'desc'  => '',
		'url'   => '',
		'image' => get_template_directory_uri() . '/assets/img/og-default.png',
		'type'  => 'website',
	);

	if ( is_front_page() ) {
		$front_id = (int) get_option( 'page_on_front' );
		$defaults = pw_seo_defaults();
		$title    = $front_id ? (string) get_post_meta( $front_id, '_pw_seo_title', true ) : '';
		$desc     = $front_id ? (string) get_post_meta( $front_id, '_pw_seo_desc', true ) : '';

		$context['title'] = '' !== $title ? $title : $defaults['front']['title'];
		$context['desc']  = '' !== $desc ? $desc : $defaults['front']['desc'];
		$context['url']   = home_url( '/' );
		return $context;
	}

	if ( is_singular() ) {
		$post_id  = get_queried_object_id();
		$default  = pw_seo_default_for( $post_id );
		$title    = (string) get_post_meta( $post_id, '_pw_seo_title', true );
		$desc     = (string) get_post_meta( $post_id, '_pw_seo_desc', true );
		$fallback = has_excerpt( $post_id ) ? get_the_excerpt( $post_id ) : get_post_field( 'post_content', $post_id );

		$context['title'] = '' !== $title ? $title : $default['title'];
		$context['desc']  = '' !== $desc ? $desc : ( '' !== $default['desc'] ? $default['desc'] : pw_seo_trim( $fallback ) );
		$context['url']   = get_permalink( $post_id );

		if ( is_singular( 'post' ) ) {
			$context['type'] = 'article';
		}

		if ( has_post_thumbnail( $post_id ) ) {
			$image = wp_get_attachment_image_url( get_post_thumbnail_id( $post_id ), 'large' );
			if ( $image ) {
				$context['image'] = $image;
			}
		}

		return $context;
	}

	$context['desc'] = pw_seo_trim( get_bloginfo( 'description' ) );

	return $context;
}

function pw_seo_document_title( $title ) {
	if ( pw_seo_plugin_active() || is_feed() ) {
		return $title;
	}

	$context = pw_seo_context();

	return '' !== $context['title'] ? $context['title'] : $title;
}
add_filter( 'pre_get_document_title', 'pw_seo_document_title', 20 );

function pw_seo_title_separator() {
	return '|';
}
add_filter( 'document_title_separator', 'pw_seo_title_separator' );

function pw_seo_breadcrumbs() {
	if ( is_front_page() || ! is_singular() ) {
		return null;
	}

	return array(
		'@type'           => 'BreadcrumbList',
		'@id'             => get_permalink() . '#breadcrumb',
		'itemListElement' => array(
			array(
				'@type'    => 'ListItem',
				'position' => 1,
				'name'     => 'Home',
				'item'     => home_url( '/' ),
			),
			array(
				'@type'    => 'ListItem',
				'position' => 2,
				'name'     => wp_strip_all_tags( get_the_title( get_queried_object_id() ) ),
				'item'     => get_permalink( get_queried_object_id() ),
			),
		),
	);
}

function pw_seo_organization() {
	$catalog = array();
	foreach ( pw_services() as $category ) {
		$offers = array();
		foreach ( $category['items'] as $item ) {
			$offers[] = array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type'       => 'Service',
					'name'        => $item[0],
					'description' => $item[1],
				),
			);
		}
		$catalog[] = array(
			'@type'           => 'OfferCatalog',
			'name'            => $category['name'],
			'itemListElement' => $offers,
		);
	}

	return array(
		'@type'           => 'ProfessionalService',
		'@id'             => home_url( '/#organization' ),
		'name'            => 'Passive Web',
		'legalName'       => 'Passive Web (Pty) Ltd',
		'slogan'          => 'Dream Catchers',
		'description'     => pw_seo_defaults()['front']['desc'],
		'url'             => home_url( '/' ),
		'logo'            => get_template_directory_uri() . '/assets/img/logo-560.png',
		'image'           => get_template_directory_uri() . '/assets/img/og-default.png',
		'email'           => 'hello@passiveweb.co.za',
		'address'         => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => 'Pretoria',
			'addressRegion'   => 'Gauteng',
			'addressCountry'  => 'ZA',
		),
		'areaServed'      => array(
			array(
				'@type' => 'City',
				'name'  => 'Pretoria',
			),
			array(
				'@type' => 'Country',
				'name'  => 'South Africa',
			),
		),
		'hasOfferCatalog' => array(
			'@type'           => 'OfferCatalog',
			'name'            => 'Passive Web services',
			'itemListElement' => $catalog,
		),
	);
}

function pw_seo_head() {
	if ( pw_seo_plugin_active() ) {
		return;
	}

	$context = pw_seo_context();
	$title   = '' !== $context['title'] ? $context['title'] : wp_get_document_title();

	if ( '' !== $context['desc'] ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $context['desc'] ) );
	}

	$og = array(
		'og:locale'    => 'en_ZA',
		'og:type'      => $context['type'],
		'og:site_name' => get_bloginfo( 'name' ),
		'og:title'     => $title,
		'og:image'     => $context['image'],
	);

	if ( '' !== $context['desc'] ) {
		$og['og:description'] = $context['desc'];
	}
	if ( '' !== $context['url'] ) {
		$og['og:url'] = $context['url'];
	}

	foreach ( $og as $property => $content ) {
		$value = in_array( $property, array( 'og:url', 'og:image' ), true ) ? esc_url( $content ) : esc_attr( $content );
		printf( '<meta property="%1$s" content="%2$s">' . "\n", esc_attr( $property ), $value );
	}

	printf( '<meta name="twitter:card" content="summary_large_image">' . "\n" );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $title ) );
	if ( '' !== $context['desc'] ) {
		printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $context['desc'] ) );
	}
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $context['image'] ) );

	$graph = array(
		pw_seo_organization(),
		array(
			'@type'      => 'WebSite',
			'@id'        => home_url( '/#website' ),
			'url'        => home_url( '/' ),
			'name'       => get_bloginfo( 'name' ),
			'inLanguage' => 'en-ZA',
			'publisher'  => array( '@id' => home_url( '/#organization' ) ),
		),
	);

	if ( '' !== $context['url'] ) {
		$page = array(
			'@type'      => is_page_template( 'page-templates/contact.php' ) ? 'ContactPage' : ( is_page_template( 'page-templates/about.php' ) ? 'AboutPage' : 'WebPage' ),
			'@id'        => $context['url'] . '#webpage',
			'url'        => $context['url'],
			'name'       => $title,
			'isPartOf'   => array( '@id' => home_url( '/#website' ) ),
			'about'      => array( '@id' => home_url( '/#organization' ) ),
			'inLanguage' => 'en-ZA',
		);
		if ( '' !== $context['desc'] ) {
			$page['description'] = $context['desc'];
		}
		$breadcrumbs = pw_seo_breadcrumbs();
		if ( $breadcrumbs ) {
			$page['breadcrumb'] = array( '@id' => $breadcrumbs['@id'] );
			$graph[]            = $breadcrumbs;
		}
		$graph[] = $page;
	}

	$json = wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP
	);

	if ( $json ) {
		echo '<script type="application/ld+json">' . $json . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'pw_seo_head', 2 );

function pw_seo_meta_box() {
	if ( pw_seo_plugin_active() ) {
		return;
	}
	foreach ( pw_seo_post_types() as $type ) {
		add_meta_box( 'pw_seo', 'Search engine listing', 'pw_seo_meta_box_render', $type, 'normal', 'low' );
	}
}
add_action( 'add_meta_boxes', 'pw_seo_meta_box' );

function pw_seo_meta_box_render( $post ) {
	wp_nonce_field( 'pw_seo_save', 'pw_seo_nonce' );

	$title   = (string) get_post_meta( $post->ID, '_pw_seo_title', true );
	$desc    = (string) get_post_meta( $post->ID, '_pw_seo_desc', true );
	$default = pw_seo_default_for( $post->ID );
	?>
	<p>
		<label for="pw_seo_title"><strong>SEO title</strong> (about 60 characters)</label><br>
		<input type="text" id="pw_seo_title" name="pw_seo_title" class="widefat" maxlength="70" placeholder="<?php echo esc_attr( $default['title'] ); ?>" value="<?php echo esc_attr( $title ); ?>">
	</p>
	<p>
		<label for="pw_seo_desc"><strong>Meta description</strong> (about 155 characters)</label><br>
		<textarea id="pw_seo_desc" name="pw_seo_desc" class="widefat" rows="3" maxlength="170" placeholder="<?php echo esc_attr( $default['desc'] ); ?>"><?php echo esc_textarea( $desc ); ?></textarea>
	</p>
	<p class="description">Leave empty to use the built-in default shown in grey. These fields are hidden and ignored while Yoast SEO or Rank Math is active.</p>
	<?php
}

function pw_seo_save( $post_id ) {
	if ( ! isset( $_POST['pw_seo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pw_seo_nonce'] ) ), 'pw_seo_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( ! in_array( get_post_type( $post_id ), pw_seo_post_types(), true ) ) {
		return;
	}

	$title = isset( $_POST['pw_seo_title'] ) ? sanitize_text_field( wp_unslash( $_POST['pw_seo_title'] ) ) : '';
	$desc  = isset( $_POST['pw_seo_desc'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pw_seo_desc'] ) ) : '';

	update_post_meta( $post_id, '_pw_seo_title', mb_substr( $title, 0, 70 ) );
	update_post_meta( $post_id, '_pw_seo_desc', mb_substr( preg_replace( '/\s+/', ' ', $desc ), 0, 170 ) );
}
add_action( 'save_post', 'pw_seo_save' );

function pw_seo_sitemap_exclude( $post_types ) {
	unset( $post_types['pw_project'] );
	return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'pw_seo_sitemap_exclude' );
