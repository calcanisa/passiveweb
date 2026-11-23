<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_items = pw_service_items();
$pw_total = count($pw_items);
$pw_cells = $pw_total + 1;
$pw_last_class = '';
if (2 === $pw_cells % 3) {
    $pw_last_class = ' pw-svc--wide';
} elseif (1 === $pw_cells % 3) {
    $pw_last_class = ' pw-svc--full';
}
?>
<section class="pw-section pw-section--dark pw-services" id="services">
    <div class="pw-services__glow" aria-hidden="true"></div>
    <div class="pw-container">
        <div class="pw-head pw-head--center">
            <?php pw_eyebrow('services_eyebrow'); ?>
            <?php pw_heading(pw_text('services_title')); ?>
            <?php if ('' !== pw_text('services_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('services_text'); ?></div>
            <?php endif; ?>
        </div>
        <?php if ($pw_total > 0) : ?>
            <div class="pw-svc-grid" data-stagger>
                <?php foreach ($pw_items as $pw_i => $pw_item) : ?>
                    <?php
                    $pw_class = '';
                    if (0 === $pw_i && $pw_total > 1) {
                        $pw_class = ' pw-svc--wide pw-svc--feature';
                    } elseif ($pw_i === $pw_total - 1 && $pw_total > 1) {
                        $pw_class = $pw_last_class;
                    }
                    ?>
                    <article class="pw-card pw-card--dark pw-svc<?php echo esc_attr($pw_class); ?>" data-reveal style="--i:<?php echo (int) $pw_i; ?>"<?php echo pw_tilt_attr(); ?>>
                        <span class="pw-card__glow" aria-hidden="true"></span>
                        <span class="pw-card__border" aria-hidden="true"></span>
                        <span class="pw-svc__num" aria-hidden="true"><?php echo esc_html(str_pad((string) ($pw_i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                        <span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon($pw_item['icon']); ?></span>
                        <h3 class="pw-card__title"><?php echo esc_html($pw_item['title']); ?></h3>
                        <?php if ('' !== $pw_item['text']) : ?>
                            <p class="pw-card__text"><?php echo esc_html($pw_item['text']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($pw_item['tags'])) : ?>
                            <ul class="pw-tags">
                                <?php foreach ($pw_item['tags'] as $pw_tag) : ?>
                                    <li><?php echo esc_html($pw_tag); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ('' !== pw_text('services_cta_text') || '' !== pw_text('services_cta_btn')) : ?>
            <div class="pw-services__cta" data-reveal>
                <?php if ('' !== pw_text('services_cta_text')) : ?>
                    <p><?php pw_e('services_cta_text'); ?></p>
                <?php endif; ?>
                <?php pw_button('services_cta_btn', 'services_cta_link', 'primary'); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
