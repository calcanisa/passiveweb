<?php
defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="pw-section pw-section--intro">
		<div class="pw-wrap pw-stack pw-stack--sm">
			<h1 class="pw-h1"><?php the_title(); ?></h1>
			<div class="pw-prose"><?php the_content(); ?></div>
		</div>
	</section>
	<?php
endwhile;

get_footer();
