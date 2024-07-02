<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://procoders.tech/
 * @since             1.0.0
 * @package           Pc_Security
 *
 * @wordpress-plugin
 * Plugin Name:       ProCod Security
 * Plugin URI:        https://https://procoders.tech/
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            ProCoders
 * Author URI:        https://https://procoders.tech//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pc-security
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
const PC_SECURITY_VERSION = '1.0.0';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pc-security-activator.php
 */
function activate_pc_security() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pc-security-activator.php';
	Pc_Security_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pc-security-deactivator.php
 */
function deactivate_pc_security() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pc-security-deactivator.php';
	Pc_Security_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pc_security' );
register_deactivation_hook( __FILE__, 'deactivate_pc_security' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pc-security.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pc_security() {

	$plugin = new Pc_Security();
	$plugin->run();

}
run_pc_security();
