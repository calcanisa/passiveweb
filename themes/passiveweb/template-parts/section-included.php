<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_items = array();
for ($pw_n = 1; $pw_n <= 6; $pw_n++) {
    if (pw_on("inc_{$pw_n}_enable") && '' !== pw_text("inc_{$pw_n}_title")) {
        $pw_items[] = $pw_n;
    }
}
?>
<section class="pw-section pw-section--light-alt pw-included" id="included">
    <div class="pw-container">
        <div class="pw-head pw-head--center">
            <?php pw_eyebrow('included_eyebrow'); ?>
            <?php pw_heading(pw_text('included_title')); ?>
            <?php if ('' !== pw_text('included_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('included_text'); ?></div>
            <?php endif; ?>
        </div>
        <?php if (!empty($pw_items)) : ?>
            <ol class="pw-included__grid" data-stagger>
                <?php foreach ($pw_items as $pw_i => $pw_n) : ?>
                    <li class="pw-card pw-card--light pw-inc" data-reveal style="--i:<?php echo (int) $pw_i; ?>"<?php echo pw_tilt_attr(); ?>>
                        <span class="pw-card__glow" aria-hidden="true"></span>
                        <div class="pw-inc__top">
                            <span class="pw-iconbox" aria-hidden="true"><?php echo pw_icon(pw_mod("inc_{$pw_n}_icon")); ?></span>
                            <span class="pw-inc__check" aria-hidden="true"><svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" focusable="false"><polyline points="20 6 9 17 4 12" pathLength="1"/></svg></span>
                        </div>
                        <h3 class="pw-card__title"><?php pw_e("inc_{$pw_n}_title"); ?></h3>
                        <?php if ('' !== pw_text("inc_{$pw_n}_text")) : ?>
                            <p class="pw-card__text"><?php pw_e("inc_{$pw_n}_text"); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
        <?php if ('' !== pw_text('included_fineprint')) : ?>
            <p class="pw-fineprint" data-reveal><?php pw_e('included_fineprint'); ?></p>
        <?php endif; ?>
    </div>
</section>
