<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_faqs = pw_faq_items();
if (empty($pw_faqs)) {
    return;
}
?>
<section class="pw-section pw-section--light-alt pw-faq" id="faq">
    <div class="pw-container pw-faq__grid">
        <div class="pw-faq__head">
            <?php pw_eyebrow('faq_eyebrow'); ?>
            <?php pw_heading(pw_text('faq_title')); ?>
            <?php if ('' !== pw_text('faq_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('faq_text'); ?></div>
            <?php endif; ?>
            <div data-reveal>
                <?php pw_button('header_cta_text', 'header_cta_link', 'dark'); ?>
            </div>
        </div>
        <div class="pw-faq__list" data-stagger>
            <?php foreach ($pw_faqs as $pw_i => $pw_faq) : ?>
                <details class="pw-faq__item" data-reveal data-faq style="--i:<?php echo (int) $pw_i; ?>"<?php echo 0 === $pw_i ? ' open' : ''; ?>>
                    <summary class="pw-faq__q">
                        <h3><?php echo esc_html($pw_faq['q']); ?></h3>
                        <span class="pw-faq__plus" aria-hidden="true"></span>
                    </summary>
                    <div class="pw-faq__a" data-faq-body><p><?php echo esc_html($pw_faq['a']); ?></p></div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
