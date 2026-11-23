<?php
if (!defined('ABSPATH')) {
    exit;
}
if (is_front_page()) {
    require get_template_directory() . '/front-page.php';
    return;
}
get_header();
?>
<section class="pw-page pw-section--light">
    <div class="pw-container pw-container--narrow">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('pw-article'); ?>>
                    <h1 class="pw-page__title"><?php the_title(); ?></h1>
                    <div class="pw-prose">
                        <?php the_content(); ?>
                    </div>
                </article>
            <?php endwhile; ?>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <h1 class="pw-page__title">Nothing here yet</h1>
            <p><a class="pw-btn pw-btn--dark" href="<?php echo esc_url(home_url('/')); ?>"><span class="pw-btn__label">Back to home</span></a></p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
