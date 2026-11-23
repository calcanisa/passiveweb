<?php
if (!defined('ABSPATH')) {
    exit;
}

function pw_mod($key)
{
    $fields = pw_flat_fields();
    $default = isset($fields[$key]) ? $fields[$key]['default'] : '';
    return get_theme_mod($key, $default);
}

function pw_on($key)
{
    return (bool) pw_mod($key);
}

function pw_text($key)
{
    return trim((string) pw_mod($key));
}

function pw_e($key)
{
    echo esc_html(pw_text($key));
}

function pw_lines($key)
{
    $raw = (string) pw_mod($key);
    $lines = preg_split('/\r\n|\r|\n/', $raw);
    $out = array();
    foreach ($lines as $line) {
        $line = trim($line);
        if ('' !== $line) {
            $out[] = $line;
        }
    }
    return $out;
}

function pw_paragraphs($key)
{
    $text = pw_text($key);
    if ('' === $text) {
        return '';
    }
    $parts = preg_split('/\n\s*\n/', str_replace("\r", '', $text));
    $html = '';
    foreach ($parts as $part) {
        $part = trim($part);
        if ('' !== $part) {
            $html .= '<p>' . nl2br(esc_html($part)) . '</p>';
        }
    }
    return $html;
}

function pw_link($value)
{
    $value = trim((string) $value);
    if ('' === $value) {
        return '#';
    }
    if (0 === strpos($value, '#')) {
        $id = preg_replace('/[^A-Za-z0-9_-]/', '', substr($value, 1));
        $anchor = '#' . $id;
        if (is_front_page() || in_array($id, pw_local_anchors(), true)) {
            return $anchor;
        }
        return home_url('/') . $anchor;
    }
    return esc_url($value);
}

function pw_section_order()
{
    $allowed = pw_section_ids();
    $raw = strtolower((string) pw_mod('section_order'));
    $order = array();
    foreach (explode(',', $raw) as $id) {
        $id = trim($id);
        if (in_array($id, $allowed, true) && !in_array($id, $order, true)) {
            $order[] = $id;
        }
    }
    if (empty($order)) {
        $order = $allowed;
    }
    return $order;
}

function pw_section_enabled($id)
{
    return pw_on($id . '_enable');
}

function pw_nav_items()
{
    $pages = array('training' => 'ai');
    $items = array();
    foreach (pw_section_order() as $id) {
        if (!pw_section_enabled($id)) {
            continue;
        }
        $label = pw_text($id . '_nav');
        if ('' === $label) {
            continue;
        }
        $url = pw_link('#' . $id);
        $page_url = isset($pages[$id]) ? pw_service_url($pages[$id]) : '';
        if ('' !== $page_url) {
            $url = $page_url;
        }
        $children = array();
        if ('services' === $id) {
            $current = pw_current_service();
            if ('' !== pw_text('footer_home_service')) {
                $children[] = array('label' => pw_text('footer_home_service'), 'url' => home_url('/'), 'current' => is_front_page());
            }
            foreach (pw_service_links() as $link) {
                $children[] = array('label' => $link['label'], 'url' => $link['url'], 'current' => $link['key'] === $current);
            }
            if (count($children) < 2) {
                $children = array();
            }
        }
        $items[] = array(
            'id' => $id,
            'label' => $label,
            'url' => $url,
            'is_page' => '' !== $page_url,
            'current' => '' !== $page_url && isset($pages[$id]) && pw_current_service() === $pages[$id],
            'children' => $children,
        );
    }
    return $items;
}

function pw_split_words($text, $start = 0)
{
    $words = preg_split('/\s+/', trim((string) $text));
    $html = array();
    $i = $start;
    foreach ($words as $word) {
        if ('' === $word) {
            continue;
        }
        $html[] = '<span class="w"><span style="--i:' . (int) $i . '">' . esc_html($word) . '</span></span>';
        $i++;
    }
    return implode(' ', $html);
}

function pw_count_words($text)
{
    $words = preg_split('/\s+/', trim((string) $text));
    return count(array_filter($words, 'strlen'));
}

function pw_count_chars($text)
{
    return function_exists('mb_strlen') ? mb_strlen((string) $text, 'UTF-8') : strlen((string) $text);
}

function pw_heading($text, $tag = 'h2', $class = 'pw-title')
{
    $allowed = array('h1', 'h2', 'h3');
    $tag = in_array($tag, $allowed, true) ? $tag : 'h2';
    if ('' === trim((string) $text)) {
        return;
    }
    echo '<' . $tag . ' class="' . esc_attr($class) . '" data-split>' . pw_split_words($text) . '</' . $tag . '>';
}

function pw_eyebrow($key)
{
    $text = pw_text($key);
    if ('' === $text) {
        return;
    }
    echo '<p class="pw-eyebrow" data-reveal><span aria-hidden="true"></span>' . esc_html($text) . '</p>';
}

function pw_tags($key)
{
    $raw = (string) pw_mod($key);
    $out = array();
    foreach (explode(',', $raw) as $tag) {
        $tag = trim($tag);
        if ('' !== $tag) {
            $out[] = $tag;
        }
    }
    return $out;
}

function pw_hex_to_rgb($hex)
{
    $hex = ltrim((string) $hex, '#');
    if (3 === strlen($hex)) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (!preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
        return '0,0,0';
    }
    return hexdec(substr($hex, 0, 2)) . ',' . hexdec(substr($hex, 2, 2)) . ',' . hexdec(substr($hex, 4, 2));
}

function pw_color($key)
{
    $value = sanitize_hex_color(pw_mod($key));
    if (!$value) {
        $fields = pw_flat_fields();
        $value = isset($fields[$key]) ? $fields[$key]['default'] : '#000000';
    }
    return $value;
}

function pw_year($text)
{
    return str_replace('{year}', wp_date('Y'), (string) $text);
}

function pw_button($text_key, $link_key, $variant = 'primary', $icon = 'arrow')
{
    $text = pw_text($text_key);
    if ('' === $text) {
        return;
    }
    $magnetic = pw_on('fx_magnetic') ? ' data-magnetic' : '';
    echo '<a class="pw-btn pw-btn--' . esc_attr($variant) . '" href="' . esc_url(pw_link(pw_mod($link_key))) . '"' . $magnetic . '><span class="pw-btn__label">' . esc_html($text) . '</span><span class="pw-btn__icon" aria-hidden="true">' . pw_icon($icon) . '</span></a>';
}

function pw_tilt_attr()
{
    return pw_on('fx_tilt') ? ' data-tilt' : ' data-spot';
}

function pw_socials()
{
    $map = array(
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'x' => 'X',
        'tiktok' => 'TikTok',
        'youtube' => 'YouTube',
    );
    $out = array();
    foreach ($map as $key => $label) {
        $url = esc_url(pw_mod('social_' . $key));
        if ('' !== $url) {
            $out[$key] = array('label' => $label, 'url' => $url);
        }
    }
    return $out;
}
