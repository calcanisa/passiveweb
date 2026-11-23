<?php
/**
 * Plugin Name: Passive Web Core
 * Plugin URI: https://passiveweb.co.za/
 * Description: Secure quote form with lead inbox, local SEO for Pretoria and South Africa, structured data and security headers for the Passive Web site. All settings live in the Customizer.
 * Version: 1.0.0
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * Author: Passive Web (Pty) Ltd
 * Author URI: https://passiveweb.co.za/
 * License: GPL-2.0-or-later
 * Text Domain: passiveweb-core
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PWC_VERSION', '1.0.0');
define('PWC_FILE', __FILE__);
define('PWC_DIR', plugin_dir_path(__FILE__));
define('PWC_URL', plugin_dir_url(__FILE__));

require PWC_DIR . 'includes/options.php';
require PWC_DIR . 'includes/customizer.php';
require PWC_DIR . 'includes/security.php';
require PWC_DIR . 'includes/leads.php';
require PWC_DIR . 'includes/handler.php';
require PWC_DIR . 'includes/form.php';
require PWC_DIR . 'includes/seo.php';
