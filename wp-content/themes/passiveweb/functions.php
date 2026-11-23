<?php
if (!defined('ABSPATH')) {
    exit;
}

define('PW_VERSION', '1.0.0');
define('PW_DIR', get_template_directory());
define('PW_URI', get_template_directory_uri());

require PW_DIR . '/inc/fields.php';
require PW_DIR . '/inc/service-pages.php';
require PW_DIR . '/inc/helpers.php';
require PW_DIR . '/inc/icons.php';
require PW_DIR . '/inc/customizer.php';
require PW_DIR . '/inc/setup.php';
require PW_DIR . '/inc/integration.php';
require PW_DIR . '/inc/projects.php';
