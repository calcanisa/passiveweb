<?php
if (!defined('ABSPATH')) {
    exit;
}

function pw_sanitize_checkbox($value)
{
    return (bool) $value;
}

function pw_sanitize_number($value, $setting)
{
    $fields = pw_flat_fields();
    $key = $setting->id;
    $value = is_numeric($value) ? (int) $value : (int) $setting->default;
    if (isset($fields[$key]['min'])) {
        $value = max((int) $fields[$key]['min'], $value);
    }
    if (isset($fields[$key]['max'])) {
        $value = min((int) $fields[$key]['max'], $value);
    }
    return $value;
}

function pw_sanitize_select($value, $setting)
{
    $fields = pw_flat_fields();
    $key = $setting->id;
    $choices = isset($fields[$key]['choices']) ? $fields[$key]['choices'] : array();
    return array_key_exists($value, $choices) ? $value : $setting->default;
}

function pw_sanitize_color($value, $setting)
{
    $clean = sanitize_hex_color($value);
    return $clean ? $clean : $setting->default;
}

function pw_sanitize_link($value)
{
    $value = trim((string) $value);
    if ('' === $value) {
        return '';
    }
    if (0 === strpos($value, '#')) {
        return '#' . preg_replace('/[^A-Za-z0-9_-]/', '', substr($value, 1));
    }
    return esc_url_raw($value, array('http', 'https', 'mailto', 'tel'));
}

function pw_sanitize_order($value)
{
    $allowed = pw_section_ids();
    $out = array();
    foreach (explode(',', strtolower((string) $value)) as $id) {
        $id = trim($id);
        if (in_array($id, $allowed, true) && !in_array($id, $out, true)) {
            $out[] = $id;
        }
    }
    return empty($out) ? implode(',', $allowed) : implode(',', $out);
}

function pw_sanitize_whatsapp($value)
{
    return preg_replace('/[^0-9]/', '', (string) $value);
}

function pw_sanitizer_for($key, $type)
{
    if ('section_order' === $key) {
        return 'pw_sanitize_order';
    }
    if ('contact_whatsapp' === $key) {
        return 'pw_sanitize_whatsapp';
    }
    if (preg_match('/_link$/', $key)) {
        return 'pw_sanitize_link';
    }
    switch ($type) {
        case 'checkbox':
            return 'pw_sanitize_checkbox';
        case 'number':
            return 'pw_sanitize_number';
        case 'select':
            return 'pw_sanitize_select';
        case 'color':
            return 'pw_sanitize_color';
        case 'textarea':
            return 'sanitize_textarea_field';
        case 'url':
        case 'image':
            return 'esc_url_raw';
        case 'email':
            return 'sanitize_email';
        case 'page':
            return 'absint';
        default:
            return 'sanitize_text_field';
    }
}

function pw_customize_register($wp_customize)
{
    $wp_customize->add_panel('pw_panel', array(
        'title' => 'Passive Web Theme',
        'description' => 'Edit every part of the one page website.',
        'priority' => 20,
    ));
    $wp_customize->add_panel('pw_sp_panel', array(
        'title' => 'Passive Web Service Pages',
        'description' => 'Edit the mobile apps, AI training and web hosting pages. Open a service page in the preview to see your changes.',
        'priority' => 21,
    ));

    $priority = 10;
    foreach (pw_fields() as $section_id => $section) {
        $wp_customize->add_section($section_id, array(
            'title' => $section['title'],
            'description' => isset($section['description']) ? $section['description'] : '',
            'panel' => isset($section['panel']) ? $section['panel'] : 'pw_panel',
            'priority' => $priority,
        ));
        $priority += 5;

        $control_priority = 1;
        foreach ($section['fields'] as $key => $def) {
            $wp_customize->add_setting($key, array(
                'default' => $def['default'],
                'type' => 'theme_mod',
                'capability' => 'edit_theme_options',
                'sanitize_callback' => pw_sanitizer_for($key, $def['type']),
                'transport' => 'refresh',
            ));

            $args = array(
                'label' => $def['label'],
                'section' => $section_id,
                'priority' => $control_priority++,
            );
            if (!empty($def['description'])) {
                $args['description'] = $def['description'];
            }

            if ('color' === $def['type']) {
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $key, $args));
                continue;
            }
            if ('image' === $def['type']) {
                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $key, $args));
                continue;
            }

            $args['type'] = 'page' === $def['type'] ? 'dropdown-pages' : $def['type'];
            if ('select' === $def['type']) {
                $args['choices'] = $def['choices'];
            }
            if ('number' === $def['type']) {
                $args['input_attrs'] = array(
                    'min' => isset($def['min']) ? $def['min'] : 0,
                    'max' => isset($def['max']) ? $def['max'] : 100000,
                    'step' => 1,
                );
            }
            $wp_customize->add_control($key, $args);
        }
    }
}
add_action('customize_register', 'pw_customize_register');

function pw_css_variables()
{
    $vars = array(
        '--bg' => pw_color('color_bg'),
        '--surface' => pw_color('color_surface'),
        '--text' => pw_color('color_text'),
        '--muted' => pw_color('color_muted'),
        '--cream' => pw_color('color_cream'),
        '--cream-2' => pw_color('color_cream_alt'),
        '--ink' => pw_color('color_ink'),
        '--a1' => pw_color('color_accent'),
        '--a2' => pw_color('color_accent_2'),
        '--a3' => pw_color('color_accent_3'),
        '--bg-rgb' => pw_hex_to_rgb(pw_color('color_bg')),
        '--text-rgb' => pw_hex_to_rgb(pw_color('color_text')),
        '--ink-rgb' => pw_hex_to_rgb(pw_color('color_ink')),
        '--a1-rgb' => pw_hex_to_rgb(pw_color('color_accent')),
        '--a2-rgb' => pw_hex_to_rgb(pw_color('color_accent_2')),
        '--a3-rgb' => pw_hex_to_rgb(pw_color('color_accent_3')),
        '--radius' => absint(pw_mod('radius')) . 'px',
        '--font-h' => '"' . pw_mod('font_heading') . '"',
        '--font-b' => '"' . pw_mod('font_body') . '"',
    );
    $css = ':root{';
    foreach ($vars as $name => $value) {
        $css .= $name . ':' . preg_replace('/[^A-Za-z0-9#,.%" -]/', '', (string) $value) . ';';
    }
    $css .= '}';
    return $css;
}
