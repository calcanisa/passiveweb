<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_email = sanitize_email(pw_mod('contact_email'));
$pw_phone = pw_text('contact_phone');
$pw_wa = preg_replace('/[^0-9]/', '', (string) pw_mod('contact_whatsapp'));
$pw_socials = pw_socials();
$pw_args = isset($args) && is_array($args) ? $args : array();
$pw_title_key = isset($pw_args['title_key']) && is_string($pw_args['title_key']) && '' !== pw_text($pw_args['title_key']) ? $pw_args['title_key'] : 'contact_title';
$pw_text_key = isset($pw_args['text_key']) && is_string($pw_args['text_key']) && '' !== pw_text($pw_args['text_key']) ? $pw_args['text_key'] : 'contact_text';
?>
<section class="pw-section pw-section--dark pw-contact" id="contact">
    <div class="pw-contact__glow" aria-hidden="true"></div>
    <div class="pw-container pw-contact__grid">
        <div class="pw-contact__copy">
            <?php pw_eyebrow('contact_eyebrow'); ?>
            <?php pw_heading(pw_text($pw_title_key)); ?>
            <?php if ('' !== pw_text($pw_text_key)) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs($pw_text_key); ?></div>
            <?php endif; ?>
            <ul class="pw-contact__list" data-stagger>
                <?php if ('' !== $pw_email) : ?>
                    <li data-reveal style="--i:0"><a href="mailto:<?php echo esc_attr(antispambot($pw_email)); ?>"><span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon('mail'); ?></span><span><?php echo esc_html(antispambot($pw_email)); ?></span></a></li>
                <?php endif; ?>
                <?php if ('' !== $pw_phone) : ?>
                    <li data-reveal style="--i:1"><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $pw_phone)); ?>"><span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon('phone'); ?></span><span><?php echo esc_html($pw_phone); ?></span></a></li>
                <?php endif; ?>
                <?php if ('' !== $pw_wa) : ?>
                    <li data-reveal style="--i:2"><a href="<?php echo esc_url('https://wa.me/' . $pw_wa); ?>" target="_blank" rel="noopener noreferrer"><span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon('whatsapp'); ?></span><span>WhatsApp</span></a></li>
                <?php endif; ?>
                <?php if ('' !== pw_text('contact_address')) : ?>
                    <li data-reveal style="--i:3"><span class="pw-contact__static"><span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon('pin'); ?></span><span><?php pw_e('contact_address'); ?></span></span></li>
                <?php endif; ?>
                <?php if ('' !== pw_text('contact_hours')) : ?>
                    <li data-reveal style="--i:4"><span class="pw-contact__static"><span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon('clock'); ?></span><span><?php pw_e('contact_hours'); ?></span></span></li>
                <?php endif; ?>
            </ul>
            <?php if (!empty($pw_socials)) : ?>
                <ul class="pw-socials" data-reveal>
                    <?php foreach ($pw_socials as $pw_key => $pw_social) : ?>
                        <li><a href="<?php echo esc_url($pw_social['url']); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($pw_social['label']); ?>"><?php echo pw_icon($pw_key); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="pw-contact__form" data-reveal>
            <div class="pw-formcard">
                <?php if (function_exists('pwc_render_form')) : ?>
                    <?php pwc_render_form(); ?>
                <?php elseif (current_user_can('activate_plugins')) : ?>
                    <p class="pw-notice">Activate the Passive Web Core plugin to show the quote form here.</p>
                <?php elseif ('' !== $pw_email) : ?>
                    <p class="pw-notice"><a href="mailto:<?php echo esc_attr(antispambot($pw_email)); ?>"><?php echo esc_html(antispambot($pw_email)); ?></a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
