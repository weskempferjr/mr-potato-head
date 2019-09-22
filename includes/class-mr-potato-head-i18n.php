<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://tnotw.com
 * @since      1.0.0
 *
 * @package    Mr_Potato_Head
 * @subpackage Mr_Potato_Head/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mr_Potato_Head
 * @subpackage Mr_Potato_Head/includes
 * @author     Wendy Emerson <wendybreaksout@gmail.com>
 */
class Mr_Potato_Head_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mr-potato-head',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
