<?php
if (!defined('ABSPATH')) {
    exit;
}

function pwc_sanitize_checkbox($value)
{
    return (bool) $value;
}

function pwc_sanitize_select($value, $setting)
{
    if (!preg_match('/\[([a-z_]+)\]$/', $setting->id, $m)) {
        return $setting->default;
    }
    $flat = pwc_flat_options();
    $choices = isset($flat[$m[1]]) ? $flat[$m[1]]['choices'] : array();
    return array_key_exists($value, $choices) ? $value : $setting->default;
}

function pwc_sanitize_coordinate($value)
{
    $value = trim((string) $value);
    if ('' === $value) {
        return '';
    }
    return is_numeric($value) ? (string) round((float) $value, 6) : '';
}

function pwc_sanitize_country($value)
{
    $value = strtoupper(preg_replace('/[^A-Za-z]/', '', (string) $value));
    return 2 === strlen($value) ? $value : 'ZA';
}

function pwc_option_sanitizer($key, $type)
{
    if ('biz_lat' === $key || 'biz_lng' === $key) {
        return 'pwc_sanitize_coordinate';
    }
    if ('biz_country' === $key) {
        return 'pwc_sanitize_country';
    }
    switch ($type) {
        case 'checkbox':
            return 'pwc_sanitize_checkbox';
        case 'select':
            return 'pwc_sanitize_select';
        case 'textarea':
            return 'sanitize_textarea_field';
        case 'email':
            return 'sanitize_email';
        case 'url':
        case 'image':
            return 'esc_url_raw';
        default:
            return 'sanitize_text_field';
    }
}

function pwc_customize_register($wp_customize)
{
    $wp_customize->add_panel('pwc_panel', array(
        'title' => 'Passive Web Core',
        'description' => 'Quote form, SEO and local business settings.',
        'priority' => 25,
    ));

    $priority = 10;
    foreach (pwc_option_fields() as $section_id => $section) {
        $wp_customize->add_section($section_id, array(
            'title' => $section['title'],
            'description' => $section['description'],
            'panel' => 'pwc_panel',
            'priority' => $priority,
        ));
        $priority += 5;

        $control_priority = 1;
        foreach ($section['fields'] as $key => $def) {
            $type = $def[0];
            $id = 'pwc_options[' . $key . ']';
            $wp_customize->add_setting($id, array(
                'default' => $def[2],
                'type' => 'option',
                'capability' => 'manage_options',
                'sanitize_callback' => pwc_option_sanitizer($key, $type),
                'transport' => 'refresh',
            ));
            $args = array(
                'label' => $def[1],
                'section' => $section_id,
                'priority' => $control_priority++,
            );
            if ('image' === $type) {
                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, $args));
                continue;
            }
            $args['type'] = $type;
            if ('select' === $type) {
                $args['choices'] = $def[3];
            }
            if ('form_recipient' === $key) {
                $args['description'] = 'Empty uses the site admin email: ' . sanitize_email(get_option('admin_email'));
            }
            $wp_customize->add_control($id, $args);
        }
    }
}
add_action('customize_register', 'pwc_customize_register');
