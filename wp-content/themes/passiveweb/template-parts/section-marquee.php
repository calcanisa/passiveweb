<?php
if (!defined('ABSPATH')) {
    exit;
}
$pw_items = pw_lines('marquee_items');
if (empty($pw_items)) {
    return;
}
?>
<div class="pw-ribbon">
    <div class="pw-ribbon__band">
        <div class="pw-ribbon__track">
            <?php for ($pw_r = 0; $pw_r < 2; $pw_r++) : ?>
                <ul class="pw-ribbon__list"<?php echo $pw_r > 0 ? ' aria-hidden="true"' : ''; ?>>
                    <?php foreach ($pw_items as $pw_item) : ?>
                        <li><?php echo esc_html($pw_item); ?><span class="pw-ribbon__star" aria-hidden="true"><?php echo pw_icon('spark'); ?></span></li>
                    <?php endforeach; ?>
                </ul>
            <?php endfor; ?>
        </div>
    </div>
</div>
