<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_cards = array();
for ($pw_n = 1; $pw_n <= 6; $pw_n++) {
    if (pw_on("aud_{$pw_n}_enable") && '' !== pw_text("aud_{$pw_n}_title")) {
        $pw_cards[] = $pw_n;
    }
}
$pw_stats = array();
for ($pw_n = 1; $pw_n <= 4; $pw_n++) {
    if (pw_on("stat_{$pw_n}_enable") && '' !== pw_text("stat_{$pw_n}_label")) {
        $pw_stats[] = $pw_n;
    }
}
?>
<section class="pw-section pw-section--light pw-about" id="about">
    <div class="pw-container">
        <div class="pw-head pw-head--split">
            <div>
                <?php pw_eyebrow('about_eyebrow'); ?>
                <?php pw_heading(pw_text('about_title')); ?>
            </div>
            <?php if ('' !== pw_text('about_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('about_text'); ?></div>
            <?php endif; ?>
        </div>
        <?php if (!empty($pw_cards)) : ?>
            <div class="pw-audience" data-stagger>
                <?php foreach ($pw_cards as $pw_i => $pw_n) : ?>
                    <article class="pw-card pw-card--light pw-audience__card" data-reveal style="--i:<?php echo (int) $pw_i; ?>"<?php echo pw_tilt_attr(); ?>>
                        <span class="pw-card__glow" aria-hidden="true"></span>
                        <span class="pw-iconbox" aria-hidden="true"><?php echo pw_icon(pw_mod("aud_{$pw_n}_icon")); ?></span>
                        <h3 class="pw-card__title"><?php pw_e("aud_{$pw_n}_title"); ?></h3>
                        <?php if ('' !== pw_text("aud_{$pw_n}_text")) : ?>
                            <p class="pw-card__text"><?php pw_e("aud_{$pw_n}_text"); ?></p>
                        <?php endif; ?>
                        <span class="pw-card__arrow" aria-hidden="true"><?php echo pw_icon('arrow'); ?></span>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($pw_stats)) : ?>
            <dl class="pw-stats" data-stagger>
                <?php foreach ($pw_stats as $pw_i => $pw_n) : ?>
                    <div class="pw-stat" data-reveal style="--i:<?php echo (int) $pw_i; ?>">
                        <dt class="pw-stat__label"><?php pw_e("stat_{$pw_n}_label"); ?></dt>
                        <dd class="pw-stat__num"><span><?php pw_e("stat_{$pw_n}_prefix"); ?></span><span data-count="<?php echo (int) pw_mod("stat_{$pw_n}_number"); ?>"><?php echo esc_html(number_format_i18n((int) pw_mod("stat_{$pw_n}_number"))); ?></span><span><?php pw_e("stat_{$pw_n}_suffix"); ?></span></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        <?php endif; ?>
    </div>
</section>
