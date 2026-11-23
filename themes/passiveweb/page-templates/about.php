<?php
/*
Template Name: About
*/

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="pw-section pw-section--intro">
		<div class="pw-wrap pw-split">
			<div class="pw-split__main">
				<p class="pw-label">Who we are</p>
				<h1 class="pw-h1">About Passive Web</h1>
				<p class="pw-quote">A Pretoria project development company that finishes what it starts.</p>
			</div>
			<div class="pw-split__side pw-copy">
				<p>Passive Web (Pty) Ltd is a South African technology company founded on the belief that the Internet is the greatest equaliser of our time. We build digital products and platforms that create real opportunities for real people.</p>
				<p>We are project developers. When a company wants to start something new, we take it from the first idea to a complete, working product, hand it over once everything works, and then market it so it gets traffic quickly.</p>
				<p>Our team is small, our ambitions are not. We work at the intersection of technology and opportunity, designing systems that generate value long after the work is done.</p>
			</div>
		</div>
	</section>

	<?php pw_editor_content(); ?>

	<section class="pw-section pw-section--flush-top">
		<div class="pw-wrap pw-stack pw-stack--sm">
			<h2 class="pw-h2 pw-h2--sm">What makes us different</h2>
			<div class="pw-cards">
				<div class="pw-box">
					<span class="pw-dot-gold" aria-hidden="true"></span>
					<h3 class="pw-box__title">Complete projects, not loose parts</h3>
					<p class="pw-box__text">Design, code, hosting and marketing come from one team, so nothing falls between the cracks.</p>
				</div>
				<div class="pw-box">
					<span class="pw-dot-gold" aria-hidden="true"></span>
					<h3 class="pw-box__title">Built to be handed over</h3>
					<p class="pw-box__text">When it works, it is yours. You own the code, the accounts and the data. No lock-in.</p>
				</div>
				<div class="pw-box">
					<span class="pw-dot-gold" aria-hidden="true"></span>
					<h3 class="pw-box__title">Traffic, not just a launch</h3>
					<p class="pw-box__text">A launch with no visitors is a waste. We market your new product hard so customers arrive quickly.</p>
				</div>
			</div>
		</div>
	</section>

	<section class="pw-section pw-section--flush-top">
		<div class="pw-wrap">
			<div class="pw-band">
				<h2 class="pw-band__title">Based in Pretoria. Building for all of <span>South Africa.</span></h2>
				<p class="pw-band__text">We work with businesses in Pretoria and right across South Africa, from first idea to finished, marketed product.</p>
			</div>
		</div>
	</section>
	<?php
endwhile;

get_template_part(
	'template-parts/section',
	'cta',
	array(
		'title'       => "Let's build something that earns its keep.",
		'lead'        => '',
		'button'      => 'Start a project',
		'second'      => 'See our process',
		'second_slug' => 'process',
	)
);

get_footer();
