<?php
if (!defined('ABSPATH')) {
    exit;
}

function pwc_register_assets()
{
    $css = PWC_DIR . 'assets/css/quote.css';
    $js = PWC_DIR . 'assets/js/quote.js';
    wp_register_style('pwc-quote', PWC_URL . 'assets/css/quote.css', array(), PWC_VERSION . '.' . (file_exists($css) ? filemtime($css) : '0'));
    wp_register_script('pwc-quote', PWC_URL . 'assets/js/quote.js', array(), PWC_VERSION . '.' . (file_exists($js) ? filemtime($js) : '0'), array(
        'in_footer' => true,
        'strategy' => 'defer',
    ));
}
add_action('wp_enqueue_scripts', 'pwc_register_assets', 5);

function pwc_status_message($code)
{
    $map = array(
        'sent' => 'msg_success',
        'limit' => 'msg_limit',
        'expired' => 'msg_expired',
        'invalid' => 'msg_error',
        'fast' => 'msg_error',
        'error' => 'msg_error',
    );
    return isset($map[$code]) ? pwc_text($map[$code]) : '';
}

function pwc_label($for, $key, $required)
{
    $html = '<label class="pwc-label" for="' . esc_attr($for) . '"><span class="pwc-label__text">' . esc_html(pwc_text($key)) . '</span>';
    if ($required && pwc_opt('show_required')) {
        $html .= '<span class="pwc-req" aria-hidden="true">*</span>';
    }
    $html .= '</label>';
    return $html;
}

function pwc_get_form()
{
    wp_enqueue_style('pwc-quote');
    wp_enqueue_script('pwc-quote');

    static $instance = 0;
    $instance++;
    $p = 'pwc' . $instance . '-';

    $status = '';
    $status_class = '';
    if (isset($_GET['pwc'])) {
        $code = sanitize_key(wp_unslash($_GET['pwc']));
        $status = pwc_status_message($code);
        $status_class = 'sent' === $code ? ' is-success' : ' is-error';
    }

    $options = pwc_lines('service_options');

    ob_start();
    ?>
    <form class="pwc-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate data-pwc-form data-endpoint="<?php echo esc_url(rest_url('pwc/v1/quote')); ?>" data-token-endpoint="<?php echo esc_url(rest_url('pwc/v1/token')); ?>" data-msg-required="<?php echo esc_attr(pwc_text('msg_required')); ?>" data-msg-email="<?php echo esc_attr(pwc_text('msg_email')); ?>" data-msg-phone="<?php echo esc_attr(pwc_text('msg_phone')); ?>" data-msg-error="<?php echo esc_attr(pwc_text('msg_error')); ?>" data-sending="<?php echo esc_attr(pwc_text('button_sending')); ?>">
        <input type="hidden" name="action" value="pwc_quote">
        <input type="hidden" name="pwc_token" value="<?php echo esc_attr(pwc_token_create()); ?>">
        <input type="hidden" name="pwc_page" value="">
        <div class="pwc-hp" aria-hidden="true">
            <label for="<?php echo esc_attr($p); ?>website">Website</label>
            <input type="text" id="<?php echo esc_attr($p); ?>website" name="pwc_website" value="" tabindex="-1" autocomplete="off">
        </div>
        <div class="pwc-grid">
            <div class="pwc-field">
                <?php echo pwc_label($p . 'name', 'label_name', true); ?>
                <input class="pwc-input" type="text" id="<?php echo esc_attr($p); ?>name" name="pwc_name" required maxlength="100" autocomplete="name" data-field="name">
                <span class="pwc-error" data-error="name" role="alert"></span>
            </div>
            <div class="pwc-field">
                <?php echo pwc_label($p . 'email', 'label_email', true); ?>
                <input class="pwc-input" type="email" id="<?php echo esc_attr($p); ?>email" name="pwc_email" required maxlength="190" autocomplete="email" inputmode="email" data-field="email">
                <span class="pwc-error" data-error="email" role="alert"></span>
            </div>
            <div class="pwc-field">
                <?php echo pwc_label($p . 'phone', 'label_phone', false); ?>
                <input class="pwc-input" type="tel" id="<?php echo esc_attr($p); ?>phone" name="pwc_phone" maxlength="30" autocomplete="tel" inputmode="tel" data-field="phone">
                <span class="pwc-error" data-error="phone" role="alert"></span>
            </div>
            <div class="pwc-field">
                <?php echo pwc_label($p . 'company', 'label_company', false); ?>
                <input class="pwc-input" type="text" id="<?php echo esc_attr($p); ?>company" name="pwc_company" maxlength="150" autocomplete="organization" data-field="company">
            </div>
            <?php if (!empty($options)) : ?>
                <div class="pwc-field pwc-field--full">
                    <?php echo pwc_label($p . 'service', 'label_service', false); ?>
                    <div class="pwc-select">
                        <select class="pwc-input" id="<?php echo esc_attr($p); ?>service" name="pwc_service" data-field="service">
                            <?php foreach ($options as $option) : ?>
                                <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            <?php endif; ?>
            <div class="pwc-field pwc-field--full">
                <?php echo pwc_label($p . 'message', 'label_message', true); ?>
                <textarea class="pwc-input pwc-textarea" id="<?php echo esc_attr($p); ?>message" name="pwc_message" rows="5" required minlength="10" maxlength="5000" placeholder="<?php echo esc_attr(pwc_text('placeholder_message')); ?>" data-field="message"></textarea>
                <span class="pwc-error" data-error="message" role="alert"></span>
            </div>
        </div>
        <button class="pwc-submit" type="submit">
            <span class="pwc-submit__label" data-label><?php echo esc_html(pwc_text('button_text')); ?></span>
            <span class="pwc-submit__icon" aria-hidden="true"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></span>
        </button>
        <p class="pwc-status<?php echo esc_attr($status_class); ?>" role="status" aria-live="polite" data-status><?php echo esc_html($status); ?></p>
        <?php if ('' !== pwc_text('privacy_note')) : ?>
            <p class="pwc-note"><?php echo esc_html(pwc_text('privacy_note')); ?></p>
        <?php endif; ?>
    </form>
    <?php
    return ob_get_clean();
}

function pwc_render_form()
{
    echo pwc_get_form();
}

add_shortcode('passiveweb_quote', 'pwc_get_form');
