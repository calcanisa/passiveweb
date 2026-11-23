<?php
if (!defined('ABSPATH')) {
    exit;
}

function pwc_raw_string($raw, $key, $max)
{
    if (!isset($raw[$key]) || !is_string($raw[$key])) {
        return '';
    }
    $value = $raw[$key];
    if (strlen($value) > $max * 4) {
        $value = substr($value, 0, $max * 4);
    }
    return $value;
}

function pwc_clean_line($value)
{
    $value = sanitize_text_field($value);
    return trim(preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $value));
}

function pwc_len($value)
{
    return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
}

function pwc_result($ok, $code, $message, $errors = array(), $status = 200)
{
    return array(
        'ok' => (bool) $ok,
        'code' => $code,
        'message' => $message,
        'errors' => $errors,
        'status' => $status,
    );
}

function pwc_validate(array $raw)
{
    $errors = array();
    $required = pwc_text('msg_required');

    $name = pwc_clean_line(pwc_raw_string($raw, 'pwc_name', 100));
    $email = sanitize_email(pwc_raw_string($raw, 'pwc_email', 190));
    $phone = pwc_clean_line(pwc_raw_string($raw, 'pwc_phone', 30));
    $company = pwc_clean_line(pwc_raw_string($raw, 'pwc_company', 150));
    $service = pwc_clean_line(pwc_raw_string($raw, 'pwc_service', 150));
    $message = sanitize_textarea_field(pwc_raw_string($raw, 'pwc_message', 5000));
    $message = trim(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/u', '', $message));

    if (pwc_len($name) < 2 || pwc_len($name) > 100) {
        $errors['name'] = $required;
    }
    if ('' === $email || !is_email($email) || pwc_len($email) > 190) {
        $errors['email'] = pwc_text('msg_email');
    }
    if ('' !== $phone && !preg_match('/^[0-9+()\s.-]{6,30}$/', $phone)) {
        $errors['phone'] = pwc_text('msg_phone');
    }
    if (pwc_len($company) > 150) {
        $company = function_exists('mb_substr') ? mb_substr($company, 0, 150, 'UTF-8') : substr($company, 0, 150);
    }
    $options = pwc_lines('service_options');
    if (!empty($options) && !in_array($service, $options, true)) {
        $service = $options[0];
    }
    if ('' === $service) {
        $service = 'General enquiry';
    }
    if (pwc_len($message) < 10 || pwc_len($message) > 5000) {
        $errors['message'] = $required;
    }
    if (preg_match_all('#https?://#i', $message) > 3) {
        $errors['message'] = pwc_text('msg_error');
    }

    return array(
        'errors' => $errors,
        'data' => array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'service' => $service,
            'message' => $message,
        ),
    );
}

function pwc_send_mail(array $data, $lead_id)
{
    $to = pwc_recipient();
    if (!is_email($to)) {
        return false;
    }
    $subject = pwc_clean_line(pwc_text('form_subject') . ': ' . $data['service'] . ' from ' . $data['name']);
    $subject = '[' . wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES) . '] ' . $subject;
    $subject = str_replace(array("\r", "\n"), ' ', $subject);

    $lines = array(
        'Name: ' . $data['name'],
        'Email: ' . $data['email'],
        'Phone: ' . ('' !== $data['phone'] ? $data['phone'] : '-'),
        'Company: ' . ('' !== $data['company'] ? $data['company'] : '-'),
        'Service: ' . $data['service'],
        '',
        'Message:',
        $data['message'],
        '',
        'Received: ' . wp_date('j F Y, H:i'),
    );
    if ($lead_id) {
        $lines[] = 'Open in WordPress: ' . admin_url('post.php?post=' . (int) $lead_id . '&action=edit');
    }

    $reply_name = trim(preg_replace('/[\r\n<>",;:\\\\]+/', ' ', $data['name']));
    $headers = array('Content-Type: text/plain; charset=UTF-8');
    if (is_email($data['email'])) {
        $headers[] = 'Reply-To: ' . $reply_name . ' <' . $data['email'] . '>';
    }
    return wp_mail($to, $subject, implode("\n", $lines), $headers);
}

function pwc_process_submission(array $raw)
{
    if (!pwc_origin_ok()) {
        return pwc_result(false, 'error', pwc_text('msg_error'), array(), 403);
    }
    if (!pwc_rate_allowed()) {
        return pwc_result(false, 'limit', pwc_text('msg_limit'), array(), 429);
    }
    pwc_rate_hit();

    if ('' !== trim(pwc_raw_string($raw, 'pwc_website', 200))) {
        return pwc_result(true, 'sent', pwc_text('msg_success'));
    }

    $token = pwc_raw_string($raw, 'pwc_token', 80);
    $state = pwc_token_check($token);
    if ('fast' === $state) {
        return pwc_result(false, 'fast', pwc_text('msg_error'), array(), 400);
    }
    if ('expired' === $state || 'used' === $state) {
        return pwc_result(false, 'expired', pwc_text('msg_expired'), array(), 400);
    }
    if ('ok' !== $state) {
        return pwc_result(false, 'expired', pwc_text('msg_expired'), array(), 400);
    }

    $checked = pwc_validate($raw);
    if (!empty($checked['errors'])) {
        return pwc_result(false, 'invalid', pwc_text('msg_error'), $checked['errors'], 422);
    }

    $data = $checked['data'];
    $page = pwc_raw_string($raw, 'pwc_page', 500);
    $page = esc_url_raw($page);
    $home = wp_parse_url(home_url(), PHP_URL_HOST);
    $data['page'] = ($page && wp_parse_url($page, PHP_URL_HOST) === $home) ? $page : home_url('/');

    pwc_token_burn($token);
    $lead_id = pwc_save_lead($data);
    $mailed = pwc_send_mail($data, $lead_id);

    if (!$lead_id && !$mailed) {
        return pwc_result(false, 'error', pwc_text('msg_error'), array(), 500);
    }

    do_action('pwc_quote_received', $lead_id, $data);
    return pwc_result(true, 'sent', pwc_text('msg_success'));
}

function pwc_rest_routes()
{
    register_rest_route('pwc/v1', '/token', array(
        'methods' => 'GET',
        'callback' => 'pwc_rest_token',
        'permission_callback' => '__return_true',
    ));
    register_rest_route('pwc/v1', '/quote', array(
        'methods' => 'POST',
        'callback' => 'pwc_rest_quote',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'pwc_rest_routes');

function pwc_rest_token()
{
    $response = new WP_REST_Response(array('token' => pwc_token_create()), 200);
    $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    $response->header('Pragma', 'no-cache');
    return $response;
}

function pwc_rest_quote(WP_REST_Request $request)
{
    $raw = $request->get_body_params();
    if (empty($raw)) {
        $raw = $request->get_json_params();
    }
    if (!is_array($raw)) {
        $raw = array();
    }
    $result = pwc_process_submission($raw);
    $response = new WP_REST_Response(array(
        'ok' => $result['ok'],
        'code' => $result['code'],
        'message' => $result['message'],
        'errors' => (object) $result['errors'],
    ), $result['status']);
    $response->header('Cache-Control', 'no-store');
    return $response;
}

function pwc_admin_post()
{
    $raw = wp_unslash($_POST);
    $result = pwc_process_submission(is_array($raw) ? $raw : array());
    $allowed = array('sent', 'limit', 'expired', 'invalid', 'error', 'fast');
    $code = in_array($result['code'], $allowed, true) ? $result['code'] : 'error';
    $home = home_url('/');
    $page = isset($raw['pwc_page']) && is_string($raw['pwc_page']) ? esc_url_raw(substr($raw['pwc_page'], 0, 500)) : '';
    if ('' === $page) {
        $referer = wp_get_raw_referer();
        $page = $referer ? esc_url_raw(substr((string) $referer, 0, 500)) : '';
    }
    $target = wp_validate_redirect($page, $home);
    $parts = wp_parse_url($target);
    if (!is_array($parts) || empty($parts['host']) || wp_parse_url($home, PHP_URL_HOST) !== $parts['host']) {
        $target = $home;
    } else {
        $target = (isset($parts['scheme']) ? $parts['scheme'] : 'https') . '://' . $parts['host'] . (isset($parts['port']) ? ':' . (int) $parts['port'] : '') . (isset($parts['path']) ? $parts['path'] : '/');
    }
    wp_safe_redirect(add_query_arg('pwc', $code, $target) . '#contact', 303);
    exit;
}
add_action('admin_post_nopriv_pwc_quote', 'pwc_admin_post');
add_action('admin_post_pwc_quote', 'pwc_admin_post');
