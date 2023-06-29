<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Optical
 * @subpackage Woo_Optical/includes
 * @author     Artness Company <info@artnessco.cl>
 */

class Woo_Optical_i18n
{

	/**
	 * Method load_plugin_textdomain
	 *
	 * @return void
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'woo-optical',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
}
