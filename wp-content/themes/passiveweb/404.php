<?php
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<section class="pw-page pw-page--404">
    <div class="pw-container pw-container--narrow">
        <p class="pw-page__code" aria-hidden="true">404</p>
        <h1 class="pw-page__title">This dream got away</h1>
        <p class="pw-page__lead">The page you are looking for does not exist or has moved.</p>
        <a class="pw-btn pw-btn--primary" href="<?php echo esc_url(home_url('/')); ?>"><span class="pw-btn__label">Back to home</span><span class="pw-btn__icon" aria-hidden="true"><?php echo pw_icon('arrow'); ?></span></a>
    </div>
</section>
<?php
get_footer();
