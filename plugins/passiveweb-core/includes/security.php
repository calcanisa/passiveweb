<?php
if (!defined('ABSPATH')) {
    exit;
}

function pwc_send_security_headers()
{
    if (is_admin() || headers_sent() || !pwc_opt('security_headers')) {
        return;
    }
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    if (is_ssl()) {
        header('Strict-Transport-Security: max-age=31536000');
    }
}
add_action('send_headers', 'pwc_send_security_headers');

function pwc_client_ip()
{
    $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';
    $ip = (string) apply_filters('pwc_client_ip', $ip);
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

function pwc_ip_hash()
{
    return hash_hmac('sha256', pwc_client_ip(), wp_salt('auth'));
}

function pwc_token_create()
{
    $ts = (string) time();
    return $ts . '.' . hash_hmac('sha256', $ts . '|pwc_quote', wp_salt('nonce'));
}

function pwc_token_check($token)
{
    if (!is_string($token) || !preg_match('/^(\d{10})\.([a-f0-9]{64})$/', $token, $m)) {
        return 'invalid';
    }
    $expected = hash_hmac('sha256', $m[1] . '|pwc_quote', wp_salt('nonce'));
    if (!hash_equals($expected, $m[2])) {
        return 'invalid';
    }
    $age = time() - (int) $m[1];
    if ($age < 3) {
        return 'fast';
    }
    if ($age > 6 * HOUR_IN_SECONDS) {
        return 'expired';
    }
    if (get_transient('pwc_used_' . substr($m[2], 0, 40))) {
        return 'used';
    }
    return 'ok';
}

function pwc_token_burn($token)
{
    if (is_string($token) && preg_match('/^\d{10}\.([a-f0-9]{64})$/', $token, $m)) {
        set_transient('pwc_used_' . substr($m[1], 0, 40), 1, 7 * HOUR_IN_SECONDS);
    }
}

function pwc_rate_allowed()
{
    $per_ip = (int) apply_filters('pwc_rate_limit_ip', 8);
    $global = (int) apply_filters('pwc_rate_limit_global', 80);
    $ip_hits = (int) get_transient('pwc_rl_' . substr(pwc_ip_hash(), 0, 40));
    $all_hits = (int) get_transient('pwc_rl_all');
    return $ip_hits < $per_ip && $all_hits < $global;
}

function pwc_rate_hit()
{
    $key = 'pwc_rl_' . substr(pwc_ip_hash(), 0, 40);
    set_transient($key, (int) get_transient($key) + 1, HOUR_IN_SECONDS);
    set_transient('pwc_rl_all', (int) get_transient('pwc_rl_all') + 1, HOUR_IN_SECONDS);
}

function pwc_origin_ok()
{
    $home = wp_parse_url(home_url(), PHP_URL_HOST);
    $candidates = array();
    if (!empty($_SERVER['HTTP_ORIGIN'])) {
        $candidates[] = sanitize_text_field(wp_unslash($_SERVER['HTTP_ORIGIN']));
    } elseif (!empty($_SERVER['HTTP_REFERER'])) {
        $candidates[] = esc_url_raw(wp_unslash($_SERVER['HTTP_REFERER']));
    }
    foreach ($candidates as $url) {
        if ('null' === $url) {
            return false;
        }
        $host = wp_parse_url($url, PHP_URL_HOST);
        if ($host && strtolower($host) !== strtolower((string) $home)) {
            return false;
        }
    }
    return true;
}
