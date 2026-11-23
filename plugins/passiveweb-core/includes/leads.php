<?php
if (!defined('ABSPATH')) {
    exit;
}

function pwc_register_leads()
{
    $cap = 'manage_options';
    register_post_type('pwc_lead', array(
        'labels' => array(
            'name' => 'Quote Requests',
            'singular_name' => 'Quote Request',
            'menu_name' => 'Quote Requests',
            'all_items' => 'All Quote Requests',
            'edit_item' => 'Quote Request',
            'view_item' => 'View Quote Request',
            'search_items' => 'Search Quote Requests',
            'not_found' => 'No quote requests yet',
            'not_found_in_trash' => 'No quote requests in the bin',
        ),
        'public' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'show_in_admin_bar' => false,
        'show_in_rest' => false,
        'has_archive' => false,
        'rewrite' => false,
        'query_var' => false,
        'can_export' => true,
        'menu_position' => 26,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => array('title'),
        'map_meta_cap' => false,
        'capabilities' => array(
            'edit_post' => $cap,
            'read_post' => $cap,
            'delete_post' => $cap,
            'edit_posts' => $cap,
            'edit_others_posts' => $cap,
            'delete_posts' => $cap,
            'delete_others_posts' => $cap,
            'publish_posts' => $cap,
            'read_private_posts' => $cap,
            'create_posts' => 'do_not_allow',
        ),
    ));
}
add_action('init', 'pwc_register_leads');

function pwc_lead_fields()
{
    return array(
        'name' => 'Name',
        'email' => 'Email',
        'phone' => 'Phone',
        'company' => 'Company',
        'service' => 'Service',
        'message' => 'Message',
        'page' => 'Sent from',
    );
}

function pwc_save_lead(array $data)
{
    $title = $data['name'] . ' · ' . $data['service'];
    $post_id = wp_insert_post(array(
        'post_type' => 'pwc_lead',
        'post_status' => 'private',
        'post_title' => wp_strip_all_tags($title),
        'post_content' => '',
        'comment_status' => 'closed',
        'ping_status' => 'closed',
    ), true);
    if (is_wp_error($post_id) || !$post_id) {
        return 0;
    }
    foreach (array_keys(pwc_lead_fields()) as $key) {
        if (isset($data[$key])) {
            update_post_meta($post_id, '_pwc_' . $key, $data[$key]);
        }
    }
    update_post_meta($post_id, '_pwc_ip_hash', substr(pwc_ip_hash(), 0, 16));
    return (int) $post_id;
}

function pwc_lead_meta_box()
{
    add_meta_box('pwc_lead_details', 'Request details', 'pwc_render_lead_box', 'pwc_lead', 'normal', 'high');
    remove_meta_box('slugdiv', 'pwc_lead', 'normal');
}
add_action('add_meta_boxes', 'pwc_lead_meta_box');

function pwc_render_lead_box($post)
{
    echo '<table class="widefat striped" style="border:0"><tbody>';
    foreach (pwc_lead_fields() as $key => $label) {
        $value = (string) get_post_meta($post->ID, '_pwc_' . $key, true);
        if ('' === $value) {
            continue;
        }
        echo '<tr><th style="width:140px;font-weight:600">' . esc_html($label) . '</th><td>';
        if ('email' === $key && is_email($value)) {
            echo '<a href="' . esc_url('mailto:' . $value) . '">' . esc_html($value) . '</a>';
        } elseif ('phone' === $key) {
            echo '<a href="' . esc_url('tel:' . preg_replace('/[^0-9+]/', '', $value)) . '">' . esc_html($value) . '</a>';
        } elseif ('page' === $key) {
            echo '<a href="' . esc_url($value) . '" target="_blank" rel="noopener noreferrer">' . esc_html($value) . '</a>';
        } else {
            echo nl2br(esc_html($value));
        }
        echo '</td></tr>';
    }
    echo '<tr><th style="font-weight:600">Received</th><td>' . esc_html(get_the_date('j F Y, H:i', $post)) . '</td></tr>';
    echo '</tbody></table>';
}

function pwc_lead_columns($columns)
{
    return array(
        'cb' => isset($columns['cb']) ? $columns['cb'] : '',
        'title' => 'Request',
        'pwc_email' => 'Email',
        'pwc_phone' => 'Phone',
        'pwc_service' => 'Service',
        'date' => 'Received',
    );
}
add_filter('manage_pwc_lead_posts_columns', 'pwc_lead_columns');

function pwc_lead_column_content($column, $post_id)
{
    $map = array('pwc_email' => 'email', 'pwc_phone' => 'phone', 'pwc_service' => 'service');
    if (!isset($map[$column])) {
        return;
    }
    $value = (string) get_post_meta($post_id, '_pwc_' . $map[$column], true);
    if ('email' === $map[$column] && is_email($value)) {
        echo '<a href="' . esc_url('mailto:' . $value) . '">' . esc_html($value) . '</a>';
        return;
    }
    echo esc_html($value);
}
add_action('manage_pwc_lead_posts_custom_column', 'pwc_lead_column_content', 10, 2);

function pwc_lead_row_actions($actions, $post)
{
    if ('pwc_lead' === $post->post_type) {
        unset($actions['inline hide-if-no-js'], $actions['view']);
    }
    return $actions;
}
add_filter('post_row_actions', 'pwc_lead_row_actions', 10, 2);
