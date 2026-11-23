<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_nav = pw_nav_items();
$pw_socials = pw_socials();
?>
</main>
<footer class="pw-footer">
    <div class="pw-container">
        <?php if ('' !== pw_text('footer_big')) : ?>
            <p class="pw-footer__big" aria-hidden="true" data-spot><?php pw_e('footer_big'); ?></p>
        <?php endif; ?>
        <div class="pw-footer__grid">
            <div class="pw-footer__brand">
                <a class="pw-brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php echo pw_mark('pw-brand__mark'); ?>
                    <span class="pw-brand__text">
                        <span class="pw-brand__name"><?php pw_e('logo_text'); ?></span>
                        <?php if ('' !== pw_text('logo_tagline')) : ?>
                            <span class="pw-brand__tag"><?php pw_e('logo_tagline'); ?></span>
                        <?php endif; ?>
                    </span>
                </a>
                <?php if ('' !== pw_text('footer_text')) : ?>
                    <p class="pw-footer__text"><?php pw_e('footer_text'); ?></p>
                <?php endif; ?>
            </div>
            <?php if (!empty($pw_nav)) : ?>
                <nav class="pw-footer__nav" aria-label="Footer menu">
                    <ul>
                        <?php foreach ($pw_nav as $pw_item) : ?>
                            <li><a href="<?php echo esc_url(pw_link('#' . $pw_item['id'])); ?>"><?php echo esc_html($pw_item['label']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            <div class="pw-footer__contact">
                <?php if ('' !== pw_text('contact_email')) : ?>
                    <a href="mailto:<?php echo esc_attr(antispambot(sanitize_email(pw_mod('contact_email')))); ?>"><?php echo esc_html(antispambot(sanitize_email(pw_mod('contact_email')))); ?></a>
                <?php endif; ?>
                <?php if ('' !== pw_text('contact_phone')) : ?>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', pw_text('contact_phone'))); ?>"><?php pw_e('contact_phone'); ?></a>
                <?php endif; ?>
                <?php if ('' !== pw_text('contact_address')) : ?>
                    <span><?php pw_e('contact_address'); ?></span>
                <?php endif; ?>
                <?php if (!empty($pw_socials)) : ?>
                    <ul class="pw-socials">
                        <?php foreach ($pw_socials as $pw_key => $pw_social) : ?>
                            <li><a href="<?php echo esc_url($pw_social['url']); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($pw_social['label']); ?>"><?php echo pw_icon($pw_key); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <div class="pw-footer__bottom">
            <p><?php echo esc_html(pw_year(pw_text('footer_copyright'))); ?></p>
            <?php if ('' !== pw_text('footer_top_text')) : ?>
                <a class="pw-footer__top" href="#top"><?php pw_e('footer_top_text'); ?><span aria-hidden="true"><?php echo pw_icon('arrow-up'); ?></span></a>
            <?php endif; ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
