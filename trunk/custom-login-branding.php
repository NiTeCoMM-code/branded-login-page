<?php
/**
 * Plugin Name: Custom Login Branding
 * Plugin URI: https://braxtonmoody.com
 * Description: Adds a configurable branded WordPress login page with logo, background image, color controls, and basic security options.
 * Version: 1.0.1
 * Author: Braxton Moody
 * Author URI: https://braxtonmoody.com
 * License: GPLv2 or later
 * Text Domain: custom-login-branding
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CLB_VERSION', '1.0.1' );
define( 'CLB_PLUGIN_FILE', __FILE__ );
define( 'CLB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CLB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CLB_OPTION_KEY', 'clb_options' );

require_once CLB_PLUGIN_DIR . 'includes/helpers.php';
require_once CLB_PLUGIN_DIR . 'includes/admin.php';
require_once CLB_PLUGIN_DIR . 'includes/login-page.php';
require_once CLB_PLUGIN_DIR . 'includes/security.php';