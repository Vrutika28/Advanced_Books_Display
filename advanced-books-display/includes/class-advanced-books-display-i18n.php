<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://http://linkedin.com/in/vrutika-darji
 * @since      1.0.0
 *
 * @package    Advanced_Books_Display
 * @subpackage Advanced_Books_Display/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Advanced_Books_Display
 * @subpackage Advanced_Books_Display/includes
 * @author     Vrutika Darji <vrutikadarji228@gmail.com>
 */
class Advanced_Books_Display_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'advanced-books-display',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
