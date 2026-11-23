<?php
/*
Template Name: Services
*/

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="pw-section pw-section--intro">
		<div class="pw-wrap pw-head pw-head--wide">
			<p class="pw-label">What we do</p>
			<h1 class="pw-h1">Services built to earn their keep</h1>
			<p class="pw-lead">From the first sketch to the server it runs on, we cover every layer a modern business needs online. Hand us the whole project, or pick only the service you need.</p>
		</div>
	</section>

	<section class="pw-section pw-section--flush-top pw-section--tight">
		<div class="pw-wrap pw-pair">
			<div class="pw-panel pw-panel--dark">
				<span class="pw-tag pw-tag--gold">Option one</span>
				<h2 class="pw-panel__title">A complete project</h2>
				<p class="pw-panel__text">We plan, design, build and launch the whole thing, hand it over once everything works, then market it hard so traffic arrives fast.</p>
				<a class="pw-link pw-link--light" href="<?php echo esc_url( pw_page_url( 'process' ) ); ?>">How it works &rarr;</a>
			</div>
			<div class="pw-panel">
				<span class="pw-tag">Option two</span>
				<h2 class="pw-panel__title">Individual online services</h2>
				<p class="pw-panel__text">Already have a product? Pick any service below: a new logo, a security audit, hosting, or a marketing campaign.</p>
				<a class="pw-link" href="#services-list">Browse services &darr;</a>
			</div>
		</div>
	</section>

	<?php get_template_part( 'template-parts/section', 'guarantee' ); ?>

	<section id="services-list" class="pw-section pw-section--flush-top">
		<div class="pw-wrap pw-services">
			<?php foreach ( pw_services() as $pw_category ) : ?>
				<div class="pw-service" id="<?php echo esc_attr( sanitize_title( $pw_category['name'] ) ); ?>">
					<div class="pw-service__head">
						<span class="pw-icon-circle"><?php pw_icon( $pw_category['icon'] ); ?></span>
						<h2 class="pw-service__title"><?php echo esc_html( $pw_category['name'] ); ?></h2>
					</div>
					<p class="pw-service__desc"><?php echo esc_html( $pw_category['description'] ); ?></p>
					<ul class="pw-service__list">
						<?php foreach ( $pw_category['items'] as $pw_item ) : ?>
							<li>
								<h3><?php echo esc_html( $pw_item[0] ); ?></h3>
								<p><?php echo esc_html( $pw_item[1] ); ?></p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	pw_editor_content();
endwhile;

get_template_part(
	'template-parts/section',
	'cta',
	array(
		'title' => 'Not sure where to start?',
		'lead'  => "Tell us what you're trying to achieve and we'll map out the right services for it.",
	)
);

get_footer();
