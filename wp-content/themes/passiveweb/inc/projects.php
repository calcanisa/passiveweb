<?php
if (!defined('ABSPATH')) {
    exit;
}

function pw_register_projects()
{
    register_post_type('pw_project', array(
        'labels' => array(
            'name' => 'Projects',
            'singular_name' => 'Project',
            'add_new_item' => 'Add New Project',
            'edit_item' => 'Edit Project',
            'new_item' => 'New Project',
            'view_item' => 'View Project',
            'search_items' => 'Search Projects',
            'not_found' => 'No projects found',
            'not_found_in_trash' => 'No projects found in Trash',
            'all_items' => 'All Projects',
            'menu_name' => 'Projects',
            'featured_image' => 'Screenshot',
            'set_featured_image' => 'Set screenshot',
            'remove_featured_image' => 'Remove screenshot',
            'use_featured_image' => 'Use as screenshot',
        ),
        'public' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_position' => 21,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'excerpt', 'thumbnail', 'page-attributes'),
        'has_archive' => false,
        'rewrite' => false,
        'query_var' => false,
    ));
    add_image_size('pw-shot', 960, 600, array('center', 'top'));
}
add_action('init', 'pw_register_projects');

function pw_project_thumbnail_support()
{
    add_theme_support('post-thumbnails', array('post', 'page', 'pw_project'));
}
add_action('after_setup_theme', 'pw_project_thumbnail_support', 11);

function pw_project_meta_box()
{
    add_meta_box('pw_project_details', 'Project details', 'pw_project_meta_box_render', 'pw_project', 'normal', 'high');
}
add_action('add_meta_boxes', 'pw_project_meta_box');

function pw_project_meta_box_render($post)
{
    wp_nonce_field('pw_project_save', 'pw_project_nonce');
    $tag = (string) get_post_meta($post->ID, '_pw_tag', true);
    $url = (string) get_post_meta($post->ID, '_pw_url', true);
    $services = (string) get_post_meta($post->ID, '_pw_services', true);
    ?>
    <p>
        <label for="pw_tag"><strong>Type of project</strong></label><br>
        <input type="text" id="pw_tag" name="pw_tag" class="widefat" maxlength="40" placeholder="Business website" value="<?php echo esc_attr($tag); ?>">
    </p>
    <p>
        <label for="pw_url"><strong>Live site URL</strong></label><br>
        <input type="url" id="pw_url" name="pw_url" class="widefat" maxlength="200" placeholder="https://" value="<?php echo esc_attr($url); ?>">
    </p>
    <p>
        <label for="pw_services"><strong>What we did (comma separated)</strong></label><br>
        <input type="text" id="pw_services" name="pw_services" class="widefat" maxlength="200" placeholder="Web design, Hosting, SEO" value="<?php echo esc_attr($services); ?>">
    </p>
    <p class="description">The excerpt is the short description on the card. Set a screenshot of the website as the featured image (at least 960 by 600 pixels, the top of the page is shown). Use Order under Page Attributes to sort projects, lowest first.</p>
    <?php
}

function pw_project_save($post_id)
{
    if (!isset($_POST['pw_project_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['pw_project_nonce'])), 'pw_project_save')) {
        return;
    }
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_revision($post_id) || !current_user_can('edit_post', $post_id)) {
        return;
    }
    $tag = isset($_POST['pw_tag']) ? sanitize_text_field(wp_unslash($_POST['pw_tag'])) : '';
    update_post_meta($post_id, '_pw_tag', mb_substr($tag, 0, 40));

    $url = isset($_POST['pw_url']) ? esc_url_raw(trim(wp_unslash($_POST['pw_url'])), array('http', 'https')) : '';
    update_post_meta($post_id, '_pw_url', mb_substr($url, 0, 200));

    $services = isset($_POST['pw_services']) ? sanitize_text_field(wp_unslash($_POST['pw_services'])) : '';
    update_post_meta($post_id, '_pw_services', mb_substr($services, 0, 200));
}
add_action('save_post_pw_project', 'pw_project_save');

function pw_get_projects($limit = 6)
{
    static $cache = array();
    $limit = max(1, min(24, absint($limit)));
    if (isset($cache[$limit])) {
        return $cache[$limit];
    }
    $query = new WP_Query(array(
        'post_type' => 'pw_project',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
    ));
    $projects = array();
    foreach ($query->posts as $post) {
        $services = array_values(array_filter(array_map('trim', explode(',', (string) get_post_meta($post->ID, '_pw_services', true))), 'strlen'));
        $url = esc_url_raw((string) get_post_meta($post->ID, '_pw_url', true), array('http', 'https'));
        $projects[] = array(
            'id' => (int) $post->ID,
            'title' => get_the_title($post),
            'tag' => (string) get_post_meta($post->ID, '_pw_tag', true),
            'url' => $url,
            'host' => pw_project_host($url),
            'services' => $services,
            'excerpt' => wp_strip_all_tags((string) $post->post_excerpt),
            'shot' => (int) get_post_thumbnail_id($post),
        );
    }
    $cache[$limit] = $projects;
    return $projects;
}

function pw_has_projects()
{
    return !empty(pw_get_projects(1));
}

function pw_project_host($url)
{
    $host = wp_parse_url((string) $url, PHP_URL_HOST);
    return $host ? preg_replace('/^www\./', '', $host) : '';
}
