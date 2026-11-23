<?php
if (!defined('ABSPATH')) {
    exit;
}

function pw_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', array('search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets'));
    add_theme_support('custom-logo', array(
        'height' => 80,
        'width' => 260,
        'flex-height' => true,
        'flex-width' => true,
    ));
}
add_action('after_setup_theme', 'pw_setup');

function pw_fonts_url()
{
    $weights = array(
        'Syne' => 'wght@500;600;700;800',
        'Unbounded' => 'wght@500;600;700;800',
        'Bricolage Grotesque' => 'opsz,wght@12..96,500;12..96,600;12..96,700;12..96,800',
        'Space Grotesk' => 'wght@500;600;700',
        'Familjen Grotesk' => 'wght@500;600;700',
        'Fraunces' => 'opsz,wght@9..144,500;9..144,600;9..144,700;9..144,800',
        'Playfair Display' => 'wght@500;600;700;800',
        'Outfit' => 'wght@400;500;600;700;800',
        'Sora' => 'wght@400;500;600;700;800',
        'Inter' => 'wght@400;500;600;700',
        'DM Sans' => 'opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700',
        'Manrope' => 'wght@400;500;600;700',
        'Plus Jakarta Sans' => 'wght@400;500;600;700',
        'Figtree' => 'wght@400;500;600;700',
    );
    $families = array_unique(array(pw_mod('font_heading'), pw_mod('font_body')));
    $parts = array();
    foreach ($families as $family) {
        if (!isset($weights[$family])) {
            continue;
        }
        $parts[] = 'family=' . str_replace(' ', '+', $family) . ':' . $weights[$family];
    }
    if (empty($parts)) {
        return '';
    }
    return 'https://fonts.googleapis.com/css2?' . implode('&', $parts) . '&display=swap';
}

function pw_asset_version($relative)
{
    $path = PW_DIR . $relative;
    return file_exists($path) ? PW_VERSION . '.' . filemtime($path) : PW_VERSION;
}

function pw_enqueue()
{
    $fonts = pw_fonts_url();
    if ('' !== $fonts) {
        wp_enqueue_style('pw-fonts', $fonts, array(), null);
    }
    wp_enqueue_style('pw-main', PW_URI . '/assets/css/main.css', array(), pw_asset_version('/assets/css/main.css'));
    wp_add_inline_style('pw-main', pw_css_variables());

    wp_enqueue_script('pw-main', PW_URI . '/assets/js/main.js', array(), pw_asset_version('/assets/js/main.js'), array(
        'in_footer' => true,
        'strategy' => 'defer',
    ));

    if (!is_admin() && !is_customize_preview()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('classic-theme-styles');
        if (is_front_page() || '' !== pw_current_service()) {
            wp_dequeue_style('global-styles');
        }
    }
}
add_action('wp_enqueue_scripts', 'pw_enqueue', 20);

function pw_resource_hints($urls, $relation)
{
    if ('preconnect' === $relation && '' !== pw_fonts_url()) {
        $urls[] = array('href' => 'https://fonts.googleapis.com');
        $urls[] = array('href' => 'https://fonts.gstatic.com', 'crossorigin');
    }
    return $urls;
}
add_filter('wp_resource_hints', 'pw_resource_hints', 10, 2);

function pw_head_early()
{
    echo '<meta name="theme-color" content="' . esc_attr(pw_color('color_bg')) . '">' . "\n";
    echo '<script>document.documentElement.classList.add("js");setTimeout(function(){document.documentElement.classList.add("pw-fallback")},3500);</script>' . "\n";
}
add_action('wp_head', 'pw_head_early', 0);

function pw_body_classes($classes)
{
    $map = array('fx_aurora' => 'aurora', 'fx_web' => 'web', 'fx_cursor' => 'cursor', 'fx_tilt' => 'tilt', 'fx_magnetic' => 'magnetic', 'fx_grain' => 'grain');
    foreach ($map as $key => $class) {
        if (pw_on($key)) {
            $classes[] = 'pw-fx-' . $class;
        }
    }
    if ('' !== pw_current_service()) {
        $classes[] = 'pw-service';
    } elseif (!is_front_page()) {
        $classes[] = 'pw-inner';
    }
    return $classes;
}
add_filter('body_class', 'pw_body_classes');

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
add_filter('the_generator', '__return_empty_string');

function pw_fallback_icons()
{
    if (has_site_icon()) {
        return;
    }
    echo '<link rel="icon" href="' . esc_url(PW_URI . '/assets/img/favicon.ico') . '" sizes="any">' . "\n";
    echo '<link rel="icon" href="' . esc_url(PW_URI . '/assets/img/favicon.svg') . '" type="image/svg+xml">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . esc_url(PW_URI . '/assets/img/apple-touch-icon.png') . '">' . "\n";
}
add_action('wp_head', 'pw_fallback_icons', 2);
