<?php
defined( 'ABSPATH' ) || exit;

function pw_register_projects() {
	register_post_type(
		'pw_project',
		array(
			'labels'              => array(
				'name'                  => 'Projects',
				'singular_name'         => 'Project',
				'add_new_item'          => 'Add New Project',
				'edit_item'             => 'Edit Project',
				'new_item'              => 'New Project',
				'view_item'             => 'View Project',
				'search_items'          => 'Search Projects',
				'not_found'             => 'No projects found',
				'not_found_in_trash'    => 'No projects found in Trash',
				'all_items'             => 'All Projects',
				'menu_name'             => 'Projects',
				'featured_image'        => 'Full-page screenshot',
				'set_featured_image'    => 'Set full-page screenshot',
				'remove_featured_image' => 'Remove full-page screenshot',
				'use_featured_image'    => 'Use as full-page screenshot',
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-portfolio',
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);
}
add_action( 'init', 'pw_register_projects' );

function pw_project_meta_box() {
	add_meta_box( 'pw_project_details', 'Project details', 'pw_project_meta_box_render', 'pw_project', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'pw_project_meta_box' );

function pw_project_meta_box_render( $post ) {
	wp_nonce_field( 'pw_project_save', 'pw_project_nonce' );

	$tag      = (string) get_post_meta( $post->ID, '_pw_tag', true );
	$url      = (string) get_post_meta( $post->ID, '_pw_url', true );
	$services = (string) get_post_meta( $post->ID, '_pw_services', true );
	?>
	<p>
		<label for="pw_tag"><strong>Tag</strong></label><br>
		<input type="text" id="pw_tag" name="pw_tag" class="widefat" maxlength="40" placeholder="Venture" value="<?php echo esc_attr( $tag ); ?>">
	</p>
	<p>
		<label for="pw_url"><strong>Live site URL</strong></label><br>
		<input type="url" id="pw_url" name="pw_url" class="widefat" maxlength="200" placeholder="https://" value="<?php echo esc_attr( $url ); ?>">
	</p>
	<p>
		<label for="pw_services"><strong>What we did (comma separated)</strong></label><br>
		<input type="text" id="pw_services" name="pw_services" class="widefat" maxlength="200" placeholder="Web platform, Mobile app, SEO" value="<?php echo esc_attr( $services ); ?>">
	</p>
	<p class="description">The excerpt is the short line on the project card. The main content is the longer description in the showcase. Set the full-page screenshot as the featured image. Use Order under Page Attributes to sort projects; the first one is featured on the home page.</p>
	<?php
}

function pw_project_save( $post_id ) {
	if ( ! isset( $_POST['pw_project_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pw_project_nonce'] ) ), 'pw_project_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$tag = isset( $_POST['pw_tag'] ) ? sanitize_text_field( wp_unslash( $_POST['pw_tag'] ) ) : '';
	update_post_meta( $post_id, '_pw_tag', mb_substr( $tag, 0, 40 ) );

	$url = isset( $_POST['pw_url'] ) ? esc_url_raw( trim( wp_unslash( $_POST['pw_url'] ) ), array( 'http', 'https' ) ) : '';
	update_post_meta( $post_id, '_pw_url', mb_substr( $url, 0, 200 ) );

	$services = isset( $_POST['pw_services'] ) ? sanitize_text_field( wp_unslash( $_POST['pw_services'] ) ) : '';
	update_post_meta( $post_id, '_pw_services', mb_substr( $services, 0, 200 ) );
}
add_action( 'save_post_pw_project', 'pw_project_save' );

function pw_get_projects( $limit = 60 ) {
	$query = new WP_Query(
		array(
			'post_type'           => 'pw_project',
			'post_status'         => 'publish',
			'posts_per_page'      => absint( $limit ),
			'orderby'             => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
		)
	);

	$projects = array();

	foreach ( $query->posts as $post ) {
		$services = preg_split( '/,/', (string) get_post_meta( $post->ID, '_pw_services', true ) );
		$services = array_values( array_filter( array_map( 'trim', is_array( $services ) ? $services : array() ), 'strlen' ) );

		$projects[] = array(
			'id'       => (int) $post->ID,
			'title'    => get_the_title( $post ),
			'tag'      => (string) get_post_meta( $post->ID, '_pw_tag', true ),
			'url'      => (string) get_post_meta( $post->ID, '_pw_url', true ),
			'services' => $services,
			'excerpt'  => (string) $post->post_excerpt,
			'content'  => (string) $post->post_content,
			'shot'     => (int) get_post_thumbnail_id( $post ),
		);
	}

	return $projects;
}

function pw_project_host( $url ) {
	$host = wp_parse_url( $url, PHP_URL_HOST );
	return $host ? preg_replace( '/^www\./', '', $host ) : '';
}

function pw_render_standin() {
	?>
	<span class="pw-standin" aria-hidden="true">
		<span class="pw-s-nav"><span class="pw-s-brand"></span><span class="pw-s-links"><span></span><span></span><span></span><span class="pw-s-pill"></span></span></span>
		<span class="pw-s-hero"><span class="pw-s-copy"><span class="pw-s-h pw-w90"></span><span class="pw-s-h pw-w65"></span><span class="pw-s-t pw-w80"></span><span class="pw-s-btn"></span></span><span class="pw-s-media"></span></span>
		<span class="pw-s-cards"><span></span><span></span><span></span></span>
		<span class="pw-s-band"></span>
		<span class="pw-s-split"><span class="pw-s-block"></span><span class="pw-s-copy"><span class="pw-s-st pw-w80"></span><span class="pw-s-gl pw-w95"></span><span class="pw-s-gl pw-w85"></span><span class="pw-s-gl pw-w60"></span></span></span>
		<span class="pw-s-cta"><span class="pw-s-h pw-w45"></span><span class="pw-s-btn"></span></span>
		<span class="pw-s-foot"></span>
	</span>
	<?php
}

function pw_render_project_card( $project, $heading = 'h2' ) {
	$heading = in_array( $heading, array( 'h2', 'h3' ), true ) ? $heading : 'h2';
	$label   = sprintf( 'Open the %s showcase', wp_strip_all_tags( $project['title'] ) );
	?>
	<article class="pw-card">
		<button type="button" class="pw-card__media" data-pw-open="<?php echo esc_attr( $project['id'] ); ?>" aria-haspopup="dialog" aria-label="<?php echo esc_attr( $label ); ?>">
			<span class="pw-card__frame">
				<span class="pw-card__chrome"><span></span><span></span><span></span></span>
				<span class="pw-card__shot">
					<?php
					if ( $project['shot'] ) {
						echo wp_get_attachment_image(
							$project['shot'],
							'pw-card',
							false,
							array(
								'class'    => 'pw-card__img',
								'alt'      => '',
								'loading'  => 'lazy',
								'decoding' => 'async',
							)
						);
					} else {
						pw_render_standin();
					}
					?>
				</span>
			</span>
		</button>
		<div class="pw-card__body">
			<?php if ( '' !== $project['tag'] ) : ?>
				<span class="pw-tag"><?php echo esc_html( $project['tag'] ); ?></span>
			<?php endif; ?>
			<<?php echo esc_html( $heading ); ?> class="pw-card__title"><?php echo esc_html( $project['title'] ); ?></<?php echo esc_html( $heading ); ?>>
			<?php if ( '' !== $project['excerpt'] ) : ?>
				<p class="pw-card__desc"><?php echo esc_html( $project['excerpt'] ); ?></p>
			<?php endif; ?>
			<div class="pw-card__actions">
				<button type="button" class="pw-btn pw-btn--sm" data-pw-open="<?php echo esc_attr( $project['id'] ); ?>" aria-haspopup="dialog">View project</button>
				<?php if ( '' !== $project['url'] ) : ?>
					<a class="pw-link" href="<?php echo esc_url( $project['url'] ); ?>" target="_blank" rel="noopener noreferrer">Visit site &rarr;</a>
				<?php endif; ?>
			</div>
		</div>
	</article>
	<?php
}

function pw_render_project_template( $project ) {
	printf(
		'<template id="pw-project-%1$s" data-host="%2$s">',
		esc_attr( $project['id'] ),
		esc_attr( pw_project_host( $project['url'] ) )
	);
	?>
	<div class="pw-m-shot">
		<?php
		if ( $project['shot'] ) {
			echo wp_get_attachment_image(
				$project['shot'],
				'pw-shot',
				false,
				array(
					'class'    => 'pw-modal__img',
					'alt'      => sprintf( 'Full-page screenshot of %s', wp_strip_all_tags( $project['title'] ) ),
					'loading'  => 'eager',
					'decoding' => 'async',
				)
			);
		} else {
			pw_render_standin();
		}
		?>
	</div>
	<div class="pw-m-info">
		<div class="pw-modal__heading">
			<?php if ( '' !== $project['tag'] ) : ?>
				<span class="pw-tag pw-tag--gold"><?php echo esc_html( $project['tag'] ); ?></span>
			<?php endif; ?>
			<h2 class="pw-modal__title" id="pw-modal-title"><?php echo esc_html( $project['title'] ); ?></h2>
		</div>
		<div class="pw-modal__desc">
			<?php
			if ( '' !== trim( $project['content'] ) ) {
				echo wp_kses_post( apply_filters( 'the_content', $project['content'] ) );
			} elseif ( '' !== $project['excerpt'] ) {
				echo '<p>' . esc_html( $project['excerpt'] ) . '</p>';
			}
			?>
		</div>
		<?php if ( $project['services'] ) : ?>
			<ul class="pw-chips">
				<?php foreach ( $project['services'] as $service ) : ?>
					<li><?php echo esc_html( $service ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<div class="pw-modal__actions">
			<?php if ( '' !== $project['url'] ) : ?>
				<a class="pw-btn pw-btn--gold" href="<?php echo esc_url( $project['url'] ); ?>" target="_blank" rel="noopener noreferrer">Visit site &rarr;</a>
			<?php endif; ?>
			<a class="pw-btn pw-btn--ghost-light" href="<?php echo esc_url( pw_page_url( 'contact' ) ); ?>">Start a project like this</a>
		</div>
	</div>
	</template>
	<?php
}

function pw_render_project_dialog() {
	?>
	<dialog class="pw-modal" id="pw-modal" aria-labelledby="pw-modal-title">
		<div class="pw-modal__box">
			<div class="pw-modal__left">
				<div class="pw-modal__chrome">
					<span class="pw-dot pw-dot--red"></span>
					<span class="pw-dot pw-dot--gold"></span>
					<span class="pw-dot pw-dot--brown"></span>
					<span class="pw-modal__url" data-pw-host></span>
					<span class="pw-modal__hint">Scroll to explore<?php pw_icon( 'arrow-down', 14, '2' ); ?></span>
				</div>
				<div class="pw-modal__scroll" data-pw-shot tabindex="0" aria-label="Website preview"></div>
			</div>
			<div class="pw-modal__side">
				<div class="pw-modal__top">
					<span class="pw-modal__count" data-pw-count></span>
					<button type="button" class="pw-modal__close" data-pw-close aria-label="Close showcase"><?php pw_icon( 'close', 20, '1.6' ); ?></button>
				</div>
				<div data-pw-info></div>
				<div class="pw-modal__nav">
					<button type="button" data-pw-prev><?php pw_icon( 'arrow-left', 16, '1.8' ); ?>Previous</button>
					<button type="button" data-pw-next>Next<?php pw_icon( 'arrow-right', 16, '1.8' ); ?></button>
				</div>
			</div>
		</div>
	</dialog>
	<?php
}
