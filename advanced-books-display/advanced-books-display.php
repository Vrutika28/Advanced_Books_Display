<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link             http://linkedin.com/in/vrutika-darji
 * @since             1.0.0
 * @package           Advanced_Books_Display
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Books Display
 * Plugin URI:        https://test.com
 * Description:       Books CPT with custom fields and AJAX filters.
 * Version:           1.0.0
 * Author:            Vrutika Darji
 * Author URI:       http://linkedin.com/in/vrutika-darji/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-books-display
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
define( 'ADVANCED_BOOKS_DISPLAY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-books-display-activator.php
 */
function activate_advanced_books_display() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-books-display-activator.php';
	Advanced_Books_Display_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-books-display-deactivator.php
 */
function deactivate_advanced_books_display() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-books-display-deactivator.php';
	Advanced_Books_Display_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_advanced_books_display' );
register_deactivation_hook( __FILE__, 'deactivate_advanced_books_display' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-books-display.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_advanced_books_display() {

	$plugin = new Advanced_Books_Display();
	$plugin->run();

}
run_advanced_books_display();
