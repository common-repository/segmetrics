<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://segmetrics.io
 * @since             1.0.0
 * @package           Segmetrics
 *
 * @wordpress-plugin
 * Plugin Name:       SegMetrics
 * Plugin URI:        https://segmetrics.io
 * Description:       Instantly include the SegMetrics tracking script to get unparalleled insights into your visitor journey
 * Version:           1.1.3
 * Author:            SegMetrics
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       segmetrics
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
define( 'SEGMETRICS_VERSION', '1.1.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-segmetrics-activator.php
 */
function activate_segmetrics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-segmetrics-activator.php';
	Segmetrics_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-segmetrics-deactivator.php
 */
function deactivate_segmetrics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-segmetrics-deactivator.php';
	Segmetrics_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_segmetrics' );
register_deactivation_hook( __FILE__, 'deactivate_segmetrics' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-segmetrics.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_segmetrics() {

	$plugin = new Segmetrics();
	$plugin->run();

}
run_segmetrics();
