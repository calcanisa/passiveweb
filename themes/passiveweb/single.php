<?php
defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="pw-section pw-section--intro">
		<div class="pw-wrap pw-stack pw-stack--sm">
			<p class="pw-label"><?php echo esc_html( get_the_date() ); ?></p>
			<h1 class="pw-h1"><?php the_title(); ?></h1>
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'large', array( 'class' => 'pw-feature-image' ) );
			}
			?>
			<div class="pw-prose"><?php the_content(); ?></div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
