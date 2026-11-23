<?php
/*
Template Name: Process
*/

defined( 'ABSPATH' ) || exit;

get_header();

$pw_steps = array(
	array( 'Build', 'Discover and quote', 'We learn your business, your goals and your budget. You get a clear written scope and quote, and we beat any other written quote you have.' ),
	array( 'Build', 'Design', 'We design the brand, screens and user journeys. You see and approve everything before a line of code is written.' ),
	array( 'Build', 'Develop', 'We build the complete product in the language and framework that fits the job, and show you progress as each part comes together.' ),
	array( 'Build', 'Test and launch', 'Every feature is tested on real devices, checked for speed and security, and then launched live.' ),
	array( 'Hand over', 'Hand over the keys', 'Only once everything works do we hand it over. The product is yours, and we walk you through how it all runs.' ),
	array( 'Market', 'Market it hard', 'Then we go after traffic with SEO, Google Ads, social media, content, email and SMS campaigns, so your new product gets visitors and customers quickly.' ),
);

$pw_handover = array(
	'A finished, tested and working product',
	'Full ownership of the code and data',
	'Your domains, hosting and account logins',
	'A walkthrough of how everything runs',
	'A marketing plan to bring in traffic fast',
);

while ( have_posts() ) :
	the_post();
	?>
	<section class="pw-section pw-section--intro">
		<div class="pw-wrap pw-head pw-head--wide">
			<p class="pw-label">Our process</p>
			<h1 class="pw-h1">From idea to traffic in six steps</h1>
			<p class="pw-lead">We start your project, finish it completely, hand it over once everything works, and then market it so customers find it quickly. Here is exactly how that happens.</p>
			<ul class="pw-phases" aria-label="Phases">
				<li>Build</li>
				<li>Hand over</li>
				<li class="is-dark">Market</li>
			</ul>
		</div>
	</section>

	<section class="pw-section pw-section--flush-top">
		<div class="pw-wrap">
			<ol class="pw-steps">
				<?php foreach ( $pw_steps as $pw_i => $pw_step ) : ?>
					<li class="pw-step<?php echo 'Market' === $pw_step[0] ? ' pw-step--market' : ''; ?>">
						<div class="pw-step__meta">
							<span class="pw-step__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $pw_i + 1 ) ); ?></span>
							<span class="pw-step__phase"><?php echo esc_html( $pw_step[0] ); ?></span>
						</div>
						<div class="pw-step__body">
							<h2 class="pw-step__title"><?php echo esc_html( $pw_step[1] ); ?></h2>
							<p class="pw-step__text"><?php echo esc_html( $pw_step[2] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<section class="pw-section pw-section--flush-top">
		<div class="pw-wrap pw-pair">
			<div class="pw-panel pw-panel--dark">
				<h2 class="pw-panel__title">What you get at handover</h2>
				<ul class="pw-checks">
					<?php foreach ( $pw_handover as $pw_item ) : ?>
						<li><?php echo esc_html( $pw_item ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="pw-panel">
				<h2 class="pw-panel__title">Want us to stay on?</h2>
				<p class="pw-panel__text">After handover you can keep us for hosting, maintenance, security and ongoing marketing. Or run it yourself. Your choice.</p>
				<a class="pw-link" href="<?php echo esc_url( pw_page_url( 'services' ) ); ?>">See our services &rarr;</a>
			</div>
		</div>
	</section>
	<?php
	pw_editor_content();
endwhile;

get_template_part(
	'template-parts/section',
	'cta',
	array(
		'title' => 'Step one is a conversation.',
		'lead'  => 'Tell us your idea and get a written quote that beats any other.',
	)
);

get_footer();
