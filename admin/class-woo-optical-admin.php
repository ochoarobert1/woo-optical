<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Optical
 * @subpackage Woo_Optical/admin
 * @author     Artness Company <info@artnessco.cl>
 */
class Woo_Optical_Admin
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
		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-optical-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Method enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-optical-admin.js', array('jquery'), $this->version, false);
	}
}
