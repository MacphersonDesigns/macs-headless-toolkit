<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://macphersondesigns.com
 * @since      1.0.0
 *
 * @package    Macs_Headless_Toolkit
 * @subpackage Macs_Headless_Toolkit/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Macs_Headless_Toolkit
 * @subpackage Macs_Headless_Toolkit/includes
 * @author     Alex Macpherson <alex@macphersondesigns.com>
 */
class Macs_Headless_Toolkit_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'more-post-types',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
