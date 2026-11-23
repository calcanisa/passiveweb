<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<section class="pw-page pw-section--light">
    <div class="pw-container pw-container--narrow">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('pw-article'); ?>>
                <h1 class="pw-page__title"><?php the_title(); ?></h1>
                <div class="pw-prose">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>
<?php
get_footer();
