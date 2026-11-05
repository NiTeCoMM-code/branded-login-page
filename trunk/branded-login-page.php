<?php
/**
 * Plugin Name: Branded Login Page
 * Plugin URI: https://wordpress.org/plugins/branded-login-page/
 * Description: Adds a configurable branded WordPress login page with logo, background image, color controls, and basic security options.
 * Version: 1.0.1
 * Author: techtankholdings
 * Author URI: https://github.com/NiTeCoMM-code
 * License: GPLv2 or later
 * Text Domain: branded-login-page
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'BLP_VERSION', '1.0.1' );
define( 'BLP_PLUGIN_FILE', __FILE__ );
define( 'BLP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BLP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BLP_OPTION_KEY', 'blp_options' );

require_once BLP_PLUGIN_DIR . 'includes/helpers.php';
require_once BLP_PLUGIN_DIR . 'includes/admin.php';
require_once BLP_PLUGIN_DIR . 'includes/login-page.php';
require_once BLP_PLUGIN_DIR . 'includes/security.php';
