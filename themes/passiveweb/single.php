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
                <p class="pw-page__lead"><time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time></p>
                <h1 class="pw-page__title"><?php the_title(); ?></h1>
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', array('class' => 'pw-article__image')); ?>
                <?php endif; ?>
                <div class="pw-prose">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</section>
<?php
get_footer();
