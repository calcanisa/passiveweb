<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_steps = array();
for ($pw_n = 1; $pw_n <= 4; $pw_n++) {
    if ('' !== pw_text("step_{$pw_n}_title")) {
        $pw_steps[] = $pw_n;
    }
}
?>
<section class="pw-section pw-section--light pw-process" id="process">
    <div class="pw-container">
        <div class="pw-head pw-head--center">
            <?php pw_eyebrow('process_eyebrow'); ?>
            <?php pw_heading(pw_text('process_title')); ?>
        </div>
        <?php if (!empty($pw_steps)) : ?>
            <ol class="pw-steps" data-steps style="--count:<?php echo count($pw_steps); ?>">
                <?php foreach ($pw_steps as $pw_i => $pw_n) : ?>
                    <li class="pw-step" data-reveal data-step style="--i:<?php echo (int) $pw_i; ?>">
                        <span class="pw-step__num" aria-hidden="true"><?php echo esc_html(str_pad((string) ($pw_i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                        <h3 class="pw-step__title"><?php pw_e("step_{$pw_n}_title"); ?></h3>
                        <p class="pw-step__text"><?php pw_e("step_{$pw_n}_text"); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>
