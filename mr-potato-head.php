<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tnotw.com
 * @since             1.0.0
 * @package           Mr_Potato_Head
 *
 * @wordpress-plugin
 * Plugin Name:       Mr Potato Head
 * Plugin URI:        https://tnotw.com/mr-potato-head
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Wendy Emerson
 * Author URI:        https://tnotw.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mr-potato-head
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MR_POTATO_HEAD_VERSION', '1.0.1' );

if (!defined('TNOTW_MPH_PLUGIN_FILE'))
	define('TNTOW_MPH_PLUGIN_FILE', plugin_basename(__FILE__) );

if (!defined('TNOTW_MPH_OPTIONS_NAME'))
	define('TNOTW_MPH_OPTIONS_NAME', 'tnotw_mph_settings');


if (!defined('MPH_TEXTDOMAIN'))
	define('MPH_TEXTDOMAIN', 'mr-potato-head');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mr-potato-head-activator.php
 */
function activate_mr_potato_head() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mr-potato-head-activator.php';
	Mr_Potato_Head_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mr-potato-head-deactivator.php
 */
function deactivate_mr_potato_head() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mr-potato-head-deactivator.php';
	Mr_Potato_Head_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mr_potato_head' );
register_deactivation_hook( __FILE__, 'deactivate_mr_potato_head' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mr-potato-head.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mr_potato_head() {

	$plugin = new Mr_Potato_Head();
	$plugin->run();

}
run_mr_potato_head();
