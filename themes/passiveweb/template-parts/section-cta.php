<?php
defined( 'ABSPATH' ) || exit;

$pw_args = wp_parse_args(
	isset( $args ) && is_array( $args ) ? $args : array(),
	array(
		'label'    => '',
		'title'    => 'Your project could be next.',
		'lead'     => 'We build it, hand it over when it works, then market it so it gets traffic fast.',
		'button'   => 'Get a quote',
		'slug'     => 'contact',
		'second'   => '',
		'second_slug' => '',
	)
);
?>
<section class="pw-cta">
	<div class="pw-wrap pw-cta__inner">
		<?php if ( '' !== $pw_args['label'] ) : ?>
			<p class="pw-label"><?php echo esc_html( $pw_args['label'] ); ?></p>
		<?php endif; ?>
		<h2 class="pw-cta__title"><?php echo esc_html( $pw_args['title'] ); ?></h2>
		<?php if ( '' !== $pw_args['lead'] ) : ?>
			<p class="pw-cta__lead"><?php echo esc_html( $pw_args['lead'] ); ?></p>
		<?php endif; ?>
		<div class="pw-actions pw-actions--center">
			<a class="pw-btn" href="<?php echo esc_url( pw_page_url( $pw_args['slug'] ) ); ?>"><?php echo esc_html( $pw_args['button'] ); ?> &rarr;</a>
			<?php if ( '' !== $pw_args['second'] && '' !== $pw_args['second_slug'] ) : ?>
				<a class="pw-btn pw-btn--outline" href="<?php echo esc_url( pw_page_url( $pw_args['second_slug'] ) ); ?>"><?php echo esc_html( $pw_args['second'] ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
