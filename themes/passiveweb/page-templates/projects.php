<?php
/*
Template Name: Projects
*/

defined( 'ABSPATH' ) || exit;

get_header();

$pw_projects = pw_get_projects( 60 );

while ( have_posts() ) :
	the_post();
	?>
	<section class="pw-section pw-section--intro">
		<div class="pw-wrap pw-stack">
			<div class="pw-head">
				<p class="pw-label">Our work</p>
				<h1 class="pw-h1">Completed projects</h1>
				<p class="pw-lead">Complete projects we planned, built, launched and handed over. Open any project to scroll through the full site, or visit it live.</p>
			</div>
			<?php if ( $pw_projects ) : ?>
				<div class="pw-grid" data-pw-grid>
					<?php
					foreach ( $pw_projects as $pw_project ) {
						pw_render_project_card( $pw_project );
					}
					?>
				</div>
				<?php
				foreach ( $pw_projects as $pw_project ) {
					pw_render_project_template( $pw_project );
				}
				?>
			<?php else : ?>
				<div class="pw-empty"><p>We're loading this section up with our recent client work. Check back soon.</p></div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	pw_editor_content();
endwhile;

if ( $pw_projects ) {
	pw_render_project_dialog();
}

get_template_part(
	'template-parts/section',
	'cta',
	array(
		'button' => 'Start a project',
	)
);

get_footer();
