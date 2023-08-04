<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://faranshaw.com
 * @since             1.0.0
 * @package           Jefferson_County
 *
 * @wordpress-plugin
 * Plugin Name:       Jefferson County
 * Plugin URI:        faranshaw.com
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Faran
 * Author URI:        https://faranshaw.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       jefferson-county
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
define( 'JEFFERSON_COUNTY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-jefferson-county-activator.php
 */
function activate_jefferson_county() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jefferson-county-activator.php';
	Jefferson_County_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-jefferson-county-deactivator.php
 */
function deactivate_jefferson_county() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-jefferson-county-deactivator.php';
	Jefferson_County_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_jefferson_county' );
register_deactivation_hook( __FILE__, 'deactivate_jefferson_county' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

 
 
require_once  plugin_dir_path( __FILE__ ) . '/vendor/autoload.php';

require plugin_dir_path( __FILE__ ) . 'includes/class-jefferson-county.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_jefferson_county() {

	$plugin = new Jefferson_County();
	$plugin->run();

}
run_jefferson_county();
