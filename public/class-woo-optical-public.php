<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Optical
 * @subpackage Woo_Optical/public
 * @author     Artness Company <info@artnessco.cl>
 */
class Woo_Optical_Public
{

	private $plugin_name;
	private $version;

	/**
	 * Method __construct
	 *
	 * @param $plugin_name $plugin_name [explicite description]
	 * @param $version $version [explicite description]
	 *
	 * @return void
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Method enqueue_styles
	 *
	 * @return void
	 */
	public function enqueue_styles()
	{
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-optical-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-optical-public.js', array('jquery'), $this->version, false);
	}
}
