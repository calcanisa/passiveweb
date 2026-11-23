<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_words = pw_lines('hero_rotating');
$pw_title_count = pw_count_words(pw_text('hero_title'));
$pw_badges = array_filter(array(pw_text('hero_badge_1'), pw_text('hero_badge_2'), pw_text('hero_badge_3')), 'strlen');
$pw_first = pw_section_order();
$pw_next = '#main';
foreach ($pw_first as $pw_id) {
    if (pw_section_enabled($pw_id)) {
        $pw_next = '#' . $pw_id;
        break;
    }
}
?>
<section class="pw-hero" id="home" aria-labelledby="pw-hero-title">
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
            <?php if ('' !== pw_text('hero_eyebrow')) : ?>
                <p class="pw-pill pw-hero__pill"><span class="pw-pill__dot" aria-hidden="true"></span><?php pw_e('hero_eyebrow'); ?></p>
            <?php endif; ?>
            <h1 class="pw-hero__title" id="pw-hero-title">
                <?php if ('' !== pw_text('hero_kicker')) : ?>
                    <span class="pw-hero__kicker"><?php pw_e('hero_kicker'); ?></span>
                <?php endif; ?>
                <?php if ('' !== pw_text('hero_title')) : ?>
                    <span class="pw-hero__line"><?php echo pw_split_words(pw_text('hero_title'), 0); ?></span>
                <?php endif; ?>
                <?php if ('' !== pw_text('hero_highlight')) : ?>
                    <span class="pw-hero__line pw-gradient-words"><?php echo pw_split_words(pw_text('hero_highlight'), $pw_title_count); ?></span>
                <?php endif; ?>
            </h1>
            <?php if (!empty($pw_words)) : ?>
                <p class="pw-hero__build pw-hero__fade" style="--d:.55s">
                    <?php pw_e('hero_build_prefix'); ?>
                    <?php
                    $pw_longest = $pw_words[0];
                    foreach ($pw_words as $pw_word) {
                        if (pw_count_chars($pw_word) > pw_count_chars($pw_longest)) {
                            $pw_longest = $pw_word;
                        }
                    }
                    ?>
                    <span class="pw-rotator" data-rotator data-words="<?php echo esc_attr(wp_json_encode(array_values($pw_words))); ?>"><span class="pw-rotator__sizer" aria-hidden="true"><?php echo esc_html($pw_longest); ?><span class="pw-rotator__caret"></span></span><span class="pw-rotator__live"><span class="pw-rotator__text" data-rotator-text><?php echo esc_html($pw_words[0]); ?></span><span class="pw-rotator__caret" aria-hidden="true"></span></span></span>
                </p>
            <?php endif; ?>
            <?php if ('' !== pw_text('hero_text')) : ?>
                <p class="pw-hero__text pw-hero__fade" style="--d:.7s"><?php pw_e('hero_text'); ?></p>
            <?php endif; ?>
            <div class="pw-hero__actions pw-hero__fade" style="--d:.85s">
                <?php pw_button('hero_btn1_text', 'hero_btn1_link', 'primary'); ?>
                <?php pw_button('hero_btn2_text', 'hero_btn2_link', 'ghost'); ?>
            </div>
            <?php if (!empty($pw_badges)) : ?>
                <ul class="pw-hero__badges pw-hero__fade" style="--d:1s">
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
        <a class="pw-scroll" href="<?php echo esc_attr($pw_next); ?>"><span class="pw-scroll__mouse" aria-hidden="true"><span></span></span><?php pw_e('hero_scroll_text'); ?></a>
    <?php endif; ?>
</section>
