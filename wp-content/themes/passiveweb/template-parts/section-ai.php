<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_rings = array();
for ($pw_n = 1; $pw_n <= 4; $pw_n++) {
    if ('' !== pw_text("ring_{$pw_n}_label")) {
        $pw_rings[] = array('label' => pw_text("ring_{$pw_n}_label"), 'value' => max(0, min(100, (int) pw_mod("ring_{$pw_n}_value"))));
    }
}
?>
<section class="pw-section pw-section--dark-alt pw-ai" id="ai">
    <div class="pw-ai__beam" aria-hidden="true"></div>
    <div class="pw-container pw-ai__grid">
        <div class="pw-ai__copy">
            <?php pw_eyebrow('ai_eyebrow'); ?>
            <?php pw_heading(pw_text('ai_title')); ?>
            <?php if ('' !== pw_text('ai_text')) : ?>
                <div class="pw-head__text" data-reveal><?php echo pw_paragraphs('ai_text'); ?></div>
            <?php endif; ?>
            <ul class="pw-pillars" data-stagger>
                <?php for ($pw_n = 1; $pw_n <= 3; $pw_n++) : ?>
                    <?php if ('' === pw_text("pillar_{$pw_n}_title")) {
                        continue;
                    } ?>
                    <li class="pw-pillar" data-reveal style="--i:<?php echo (int) $pw_n; ?>">
                        <span class="pw-iconbox pw-iconbox--glow" aria-hidden="true"><?php echo pw_icon(pw_mod("pillar_{$pw_n}_icon")); ?></span>
                        <div>
                            <h3 class="pw-pillar__title"><?php pw_e("pillar_{$pw_n}_title"); ?></h3>
                            <p class="pw-pillar__text"><?php pw_e("pillar_{$pw_n}_text"); ?></p>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
        <?php if (!empty($pw_rings)) : ?>
            <div class="pw-ai__visual" data-reveal>
                <div class="pw-console"<?php echo pw_tilt_attr(); ?>>
                    <span class="pw-card__glow" aria-hidden="true"></span>
                    <div class="pw-console__bar" aria-hidden="true"><span></span><span></span><span></span></div>
                    <?php if ('' !== pw_text('ai_rings_caption')) : ?>
                        <p class="pw-console__caption"><?php pw_e('ai_rings_caption'); ?></p>
                    <?php endif; ?>
                    <ul class="pw-rings">
                        <?php foreach ($pw_rings as $pw_ring) : ?>
                            <li class="pw-ring" style="--v:<?php echo (int) $pw_ring['value']; ?>">
                                <svg class="pw-ring__svg" viewBox="0 0 120 120" width="120" height="120" aria-hidden="true" focusable="false">
                                    <circle class="pw-ring__track" cx="60" cy="60" r="50" pathLength="100"/>
                                    <circle class="pw-ring__bar" cx="60" cy="60" r="50" pathLength="100"/>
                                </svg>
                                <span class="pw-ring__value"><span data-count="<?php echo (int) $pw_ring['value']; ?>"><?php echo (int) $pw_ring['value']; ?></span></span>
                                <span class="pw-ring__label"><?php echo esc_html($pw_ring['label']); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php $pw_console = pw_lines('ai_console_lines'); ?>
                    <?php if (!empty($pw_console)) : ?>
                        <div class="pw-console__code" aria-hidden="true">
                            <?php foreach ($pw_console as $pw_ci => $pw_line) : ?>
                                <?php if (0 === $pw_ci) : ?>
                                    <span><i>$</i> <?php echo esc_html($pw_line); ?></span>
                                <?php else : ?>
                                    <span class="pw-ok" style="--i:<?php echo (int) $pw_ci; ?>"><?php echo esc_html($pw_line); ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
