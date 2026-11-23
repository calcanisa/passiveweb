<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_ribbon = pw_text('quote_ribbon');
$pw_title_count = pw_count_words(pw_text('quote_title'));
?>
<section class="pw-section pw-section--accent pw-quote" id="quote">
    <?php if ('' !== $pw_ribbon) : ?>
        <div class="pw-quote__ribbon" aria-hidden="true">
            <div class="pw-quote__track">
                <?php for ($pw_r = 0; $pw_r < 4; $pw_r++) : ?>
                    <span><?php echo esc_html($pw_ribbon); ?></span><span class="pw-quote__star"><?php echo pw_icon('spark'); ?></span>
                <?php endfor; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="pw-container">
        <div class="pw-quote__card" data-reveal data-spot>
            <span class="pw-card__glow" aria-hidden="true"></span>
            <h2 class="pw-quote__title" data-split>
                <?php echo pw_split_words(pw_text('quote_title'), 0); ?>
                <span class="pw-gradient-words"><?php echo pw_split_words(pw_text('quote_highlight'), $pw_title_count); ?></span>
            </h2>
            <?php if ('' !== pw_text('quote_text')) : ?>
                <p class="pw-quote__text"><?php pw_e('quote_text'); ?></p>
            <?php endif; ?>
            <div class="pw-quote__actions">
                <?php pw_button('quote_btn_text', 'quote_btn_link', 'primary'); ?>
            </div>
            <div class="pw-guarantees">
                <?php for ($pw_n = 1; $pw_n <= 2; $pw_n++) : ?>
                    <?php if ('' === pw_text("guar_{$pw_n}_title")) {
                        continue;
                    } ?>
                    <div class="pw-guarantee">
                        <span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon(pw_mod("guar_{$pw_n}_icon")); ?></span>
                        <div>
                            <h3 class="pw-guarantee__title"><?php pw_e("guar_{$pw_n}_title"); ?></h3>
                            <p class="pw-guarantee__text"><?php pw_e("guar_{$pw_n}_text"); ?></p>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
