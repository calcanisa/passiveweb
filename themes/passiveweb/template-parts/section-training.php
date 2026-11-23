<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_points = pw_lines('training_points');
$pw_prompt = pw_text('training_demo_prompt');
$pw_reply = pw_text('training_demo_reply');
?>
<section class="pw-section pw-section--dark pw-training" id="training">
    <div class="pw-container pw-training__grid">
        <div class="pw-training__copy">
            <?php pw_eyebrow('training_eyebrow'); ?>
            <?php pw_heading(pw_text('training_title')); ?>
            <?php if ('' !== pw_text('training_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('training_text'); ?></div>
            <?php endif; ?>
            <?php if (!empty($pw_points)) : ?>
                <ul class="pw-checks" data-stagger>
                    <?php foreach ($pw_points as $pw_i => $pw_point) : ?>
                        <li data-reveal style="--i:<?php echo (int) $pw_i; ?>"><span class="pw-checks__icon" aria-hidden="true"><?php echo pw_icon('check'); ?></span><?php echo esc_html($pw_point); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="pw-training__actions" data-reveal>
                <?php pw_button('training_btn_text', 'training_btn_link', 'primary'); ?>
            </div>
        </div>
        <?php if ('' !== $pw_prompt || '' !== $pw_reply) : ?>
            <div class="pw-training__visual" data-reveal>
                <div class="pw-chat" data-chat<?php echo pw_tilt_attr(); ?>>
                    <span class="pw-card__glow" aria-hidden="true"></span>
                    <div class="pw-chat__head">
                        <span class="pw-chat__avatar" aria-hidden="true"><?php echo pw_icon('cpu'); ?></span>
                        <span class="pw-chat__name"><?php pw_e('training_demo_title'); ?></span>
                        <span class="pw-chat__live" aria-hidden="true"></span>
                    </div>
                    <div class="pw-chat__body">
                        <?php if ('' !== $pw_prompt) : ?>
                            <p class="pw-msg pw-msg--user" data-chat-msg data-full="<?php echo esc_attr($pw_prompt); ?>"><?php echo esc_html($pw_prompt); ?></p>
                        <?php endif; ?>
                        <p class="pw-msg pw-msg--typing" data-chat-typing aria-hidden="true"><span></span><span></span><span></span></p>
                        <?php if ('' !== $pw_reply) : ?>
                            <p class="pw-msg pw-msg--ai" data-chat-msg data-full="<?php echo esc_attr($pw_reply); ?>"><?php echo esc_html($pw_reply); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="pw-chat__input" aria-hidden="true">
                        <span><?php pw_e('training_demo_input'); ?></span>
                        <span class="pw-chat__send"><?php echo pw_icon('arrow'); ?></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
