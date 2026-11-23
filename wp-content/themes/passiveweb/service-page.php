<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_key = pw_current_service();
if ('' === $pw_key) {
    require get_template_directory() . '/page.php';
    return;
}
$pw_p = 'sp_' . $pw_key . '_';
$pw_title_count = pw_count_words(pw_sp_text($pw_key, 'hero_title'));
$pw_badges = array();
for ($pw_n = 1; $pw_n <= 3; $pw_n++) {
    if ('' !== pw_sp_text($pw_key, "badge_{$pw_n}")) {
        $pw_badges[] = pw_sp_text($pw_key, "badge_{$pw_n}");
    }
}
$pw_features = pw_service_features($pw_key);
$pw_reasons = pw_service_reasons($pw_key);
$pw_faqs = pw_service_faqs($pw_key);
$pw_related = pw_on('sp_related_enable') ? pw_service_links($pw_key) : array();
$pw_total = count($pw_features);
$pw_last_class = '';
if (2 === ($pw_total + 1) % 3) {
    $pw_last_class = ' pw-svc--wide';
} elseif (1 === ($pw_total + 1) % 3) {
    $pw_last_class = ' pw-svc--full';
}
get_header();
?>
<section class="pw-hero pw-hero--page" id="home" aria-labelledby="pw-hero-title">
    <div class="pw-hero__bg" aria-hidden="true">
        <?php if (pw_on('fx_aurora')) : ?>
            <div class="pw-aurora"><span></span><span></span><span></span><span></span></div>
        <?php endif; ?>
        <div class="pw-gridlines"></div>
        <?php if (pw_on('fx_web')) : ?>
            <canvas class="pw-web" data-web></canvas>
        <?php endif; ?>
    </div>
    <div class="pw-container pw-hero__inner<?php echo pw_on('hero_show_art') ? '' : ' pw-hero__inner--solo'; ?>">
        <div class="pw-hero__copy">
            <?php if ('' !== pw_sp_text($pw_key, 'hero_eyebrow')) : ?>
                <p class="pw-pill pw-hero__pill"><span class="pw-pill__dot" aria-hidden="true"></span><?php pw_e($pw_p . 'hero_eyebrow'); ?></p>
            <?php endif; ?>
            <h1 class="pw-hero__title" id="pw-hero-title">
                <?php if ('' !== pw_sp_text($pw_key, 'hero_kicker')) : ?>
                    <span class="pw-hero__kicker"><?php pw_e($pw_p . 'hero_kicker'); ?></span>
                <?php endif; ?>
                <?php if ('' !== pw_sp_text($pw_key, 'hero_title')) : ?>
                    <span class="pw-hero__line"><?php echo pw_split_words(pw_sp_text($pw_key, 'hero_title'), 0); ?></span>
                <?php endif; ?>
                <?php if ('' !== pw_sp_text($pw_key, 'hero_highlight')) : ?>
                    <span class="pw-hero__line pw-gradient-words"><?php echo pw_split_words(pw_sp_text($pw_key, 'hero_highlight'), $pw_title_count); ?></span>
                <?php endif; ?>
            </h1>
            <?php if ('' !== pw_sp_text($pw_key, 'hero_text')) : ?>
                <p class="pw-hero__text pw-hero__fade" style="--d:.6s"><?php pw_e($pw_p . 'hero_text'); ?></p>
            <?php endif; ?>
            <div class="pw-hero__actions pw-hero__fade" style="--d:.75s">
                <?php pw_button($pw_p . 'hero_btn1_text', $pw_p . 'hero_btn1_link', 'primary'); ?>
                <?php pw_button($pw_p . 'hero_btn2_text', $pw_p . 'hero_btn2_link', 'ghost'); ?>
            </div>
            <?php if (!empty($pw_badges)) : ?>
                <ul class="pw-hero__badges pw-hero__fade" style="--d:.9s">
                    <?php foreach ($pw_badges as $pw_badge) : ?>
                        <li><span class="pw-hero__badge-icon" aria-hidden="true"><?php echo pw_icon('check'); ?></span><?php echo esc_html($pw_badge); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <?php if (pw_on('hero_show_art')) : ?>
            <div class="pw-hero__art" aria-hidden="true" data-hero-art>
                <div class="pw-hero__art-inner" data-hero-art-inner>
                    <?php echo pw_dreamcatcher(); ?>
                </div>
                <span class="pw-orb pw-orb--1"></span>
                <span class="pw-orb pw-orb--2"></span>
                <span class="pw-orb pw-orb--3"></span>
            </div>
        <?php endif; ?>
    </div>
    <?php if ('' !== pw_text('hero_scroll_text')) : ?>
        <a class="pw-scroll" href="#intro"><span class="pw-scroll__mouse" aria-hidden="true"><span></span></span><?php pw_e('hero_scroll_text'); ?></a>
    <?php endif; ?>
</section>

<?php if ('' !== pw_sp_text($pw_key, 'intro_title') || '' !== pw_sp_text($pw_key, 'intro_text')) : ?>
<section class="pw-section pw-section--light pw-about" id="intro">
    <div class="pw-container">
        <div class="pw-head pw-head--split pw-head--top">
            <div>
                <?php pw_eyebrow($pw_p . 'intro_eyebrow'); ?>
                <?php pw_heading(pw_sp_text($pw_key, 'intro_title')); ?>
            </div>
            <?php if ('' !== pw_sp_text($pw_key, 'intro_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs($pw_p . 'intro_text'); ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ($pw_total > 0) : ?>
<section class="pw-section pw-section--dark pw-services" id="features">
    <div class="pw-services__glow" aria-hidden="true"></div>
    <div class="pw-container">
        <div class="pw-head pw-head--center">
            <?php pw_eyebrow($pw_p . 'feat_eyebrow'); ?>
            <?php pw_heading(pw_sp_text($pw_key, 'feat_title')); ?>
            <?php if ('' !== pw_sp_text($pw_key, 'feat_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs($pw_p . 'feat_text'); ?></div>
            <?php endif; ?>
        </div>
        <div class="pw-svc-grid" data-stagger>
            <?php foreach ($pw_features as $pw_i => $pw_item) : ?>
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
    </div>
</section>
<?php endif; ?>

<?php if (!empty($pw_reasons)) : ?>
<section class="pw-section pw-section--light-alt pw-included" id="why">
    <div class="pw-container">
        <div class="pw-head pw-head--center">
            <?php pw_eyebrow($pw_p . 'why_eyebrow'); ?>
            <?php pw_heading(pw_sp_text($pw_key, 'why_title')); ?>
            <?php if ('' !== pw_sp_text($pw_key, 'why_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs($pw_p . 'why_text'); ?></div>
            <?php endif; ?>
        </div>
        <ol class="pw-included__grid" data-stagger>
            <?php foreach ($pw_reasons as $pw_i => $pw_item) : ?>
                <li class="pw-card pw-card--light pw-inc" data-reveal style="--i:<?php echo (int) $pw_i; ?>"<?php echo pw_tilt_attr(); ?>>
                    <span class="pw-card__glow" aria-hidden="true"></span>
                    <div class="pw-inc__top">
                        <span class="pw-iconbox" aria-hidden="true"><?php echo pw_icon($pw_item['icon']); ?></span>
                        <span class="pw-inc__check" aria-hidden="true"><svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" focusable="false"><polyline points="20 6 9 17 4 12" pathLength="1"/></svg></span>
                    </div>
                    <h3 class="pw-card__title"><?php echo esc_html($pw_item['title']); ?></h3>
                    <?php if ('' !== $pw_item['text']) : ?>
                        <p class="pw-card__text"><?php echo esc_html($pw_item['text']); ?></p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
<?php endif; ?>

<?php
if (pw_on('sp_show_quote') && pw_section_enabled('quote')) {
    get_template_part('template-parts/section', 'quote');
}
if (pw_on('sp_show_process') && pw_section_enabled('process')) {
    get_template_part('template-parts/section', 'process');
}
?>

<?php if (!empty($pw_faqs)) : ?>
<section class="pw-section pw-section--light-alt pw-faq" id="faq">
    <div class="pw-container pw-faq__grid">
        <div class="pw-faq__head">
            <?php pw_eyebrow('sp_faq_eyebrow'); ?>
            <?php pw_heading(pw_sp_text($pw_key, 'faq_title')); ?>
            <?php if ('' !== pw_text('sp_faq_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('sp_faq_text'); ?></div>
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
<?php endif; ?>

<?php if (!empty($pw_related) || '' !== pw_text('sp_home_title')) : ?>
<section class="pw-section pw-section--light pw-about pw-related" id="related">
    <div class="pw-container">
        <div class="pw-head pw-head--center">
            <?php pw_eyebrow('sp_related_eyebrow'); ?>
            <?php pw_heading(pw_text('sp_related_title')); ?>
        </div>
        <div class="pw-audience pw-related__grid" data-stagger>
            <?php if ('' !== pw_text('sp_home_title')) : ?>
                <a class="pw-card pw-card--light pw-audience__card" href="<?php echo esc_url(home_url('/')); ?>" data-reveal style="--i:0"<?php echo pw_tilt_attr(); ?>>
                    <span class="pw-card__glow" aria-hidden="true"></span>
                    <span class="pw-iconbox" aria-hidden="true"><?php echo pw_icon(pw_mod('sp_home_icon')); ?></span>
                    <h3 class="pw-card__title"><?php pw_e('sp_home_title'); ?></h3>
                    <?php if ('' !== pw_text('sp_home_text')) : ?>
                        <p class="pw-card__text"><?php pw_e('sp_home_text'); ?></p>
                    <?php endif; ?>
                    <span class="pw-card__arrow" aria-hidden="true"><?php echo pw_icon('arrow'); ?></span>
                </a>
            <?php endif; ?>
            <?php foreach ($pw_related as $pw_i => $pw_link) : ?>
                <a class="pw-card pw-card--light pw-audience__card" href="<?php echo esc_url($pw_link['url']); ?>" data-reveal style="--i:<?php echo (int) ($pw_i + 1); ?>"<?php echo pw_tilt_attr(); ?>>
                    <span class="pw-card__glow" aria-hidden="true"></span>
                    <span class="pw-iconbox" aria-hidden="true"><?php echo pw_icon($pw_link['icon']); ?></span>
                    <h3 class="pw-card__title"><?php echo esc_html($pw_link['label']); ?></h3>
                    <?php if ('' !== $pw_link['text']) : ?>
                        <p class="pw-card__text"><?php echo esc_html($pw_link['text']); ?></p>
                    <?php endif; ?>
                    <span class="pw-card__arrow" aria-hidden="true"><?php echo pw_icon('arrow'); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
get_template_part('template-parts/section', 'contact', array(
    'title_key' => $pw_p . 'contact_title',
    'text_key' => $pw_p . 'contact_text',
));
get_footer();
