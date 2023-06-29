<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Optical
 * @subpackage Woo_Optical/includes
 * @author     Artness Company <info@artnessco.cl>
 */
class Woo_Optical
{

	protected $loader;
	protected $plugin_name;
	protected $version;

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		if (defined('WOO_OPTICAL_VERSION')) {
			$this->version = WOO_OPTICAL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woo-optical';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Method load_dependencies
	 *
	 * @return void
	 */
	private function load_dependencies()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-optical-loader.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-woo-optical-i18n.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-woo-optical-admin.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-woo-optical-public.php';

		$this->loader = new Woo_Optical_Loader();
	}

	/**
	 * Method set_locale
	 *
	 * @return void
	 */
	private function set_locale()
	{

		$plugin_i18n = new Woo_Optical_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Method define_admin_hooks
	 *
	 * @return void
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Woo_Optical_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		$this->loader->add_action('admin_menu', $plugin_admin, 'woo_optical_admin_menu');
		$this->loader->add_action('admin_init', $plugin_admin, 'woo_optical_register_settings');

		$this->loader->add_action('admin_post_woo_optical_generate_report', $plugin_admin, 'woo_optical_generate_sales_report');

		$this->loader->add_shortcode('woo_optical_report', $plugin_admin, 'woo_optical_report_shortcode');
	}

	/**
	 * Method define_public_hooks
	 *
	 * @return void
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Woo_Optical_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

		$this->loader->add_action('woocommerce_before_add_to_cart_button', $plugin_public, 'woo_optical_add_custom_table');
		$this->loader->add_action('woocommerce_before_calculate_totals', $plugin_public, 'woo_optical_update_product');
	}


	/**
	 * Method run
	 *
	 * @return void
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * Method get_plugin_name
	 *
	 * @return void
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * Method get_loader
	 *
	 * @return void
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Method get_version
	 *
	 * @return void
	 */
	public function get_version()
	{
		return $this->version;
	}
}
