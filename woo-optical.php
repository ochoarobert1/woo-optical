<?php

/**
 *
 * @link              https://artnesco.cl
 * @since             1.0.0
 * @package           Woo_Optical
 *
 * @wordpress-plugin
 * Plugin Name:       Woocommerce Optical Bundle
 * Plugin URI:        https://artnesco.cl
 * Description:       Plugin for managing options and prices for optical health products.
 * Version:           1.0.0
 * Author:            Artness Company
 * Author URI:        https://artnesco.cl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-optical
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

define('WOO_OPTICAL_VERSION', '1.0.0');

/**
 * Method activate_woo_optical
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-optical-activator.php
 *
 * @return void
 */
function activate_woo_optical()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-woo-optical-activator.php';
	Woo_Optical_Activator::activate();
}

/**
 * Method deactivate_woo_optical
 * 
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-optical-deactivator.php
 * 
 * @return void
 */
function deactivate_woo_optical()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-woo-optical-deactivator.php';
	Woo_Optical_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woo_optical');
register_deactivation_hook(__FILE__, 'deactivate_woo_optical');

require plugin_dir_path(__FILE__) . 'includes/class-woo-optical.php';

/**
 * Method run_woo_optical
 *
 * @return void
 */
function run_woo_optical()
{

	$plugin = new Woo_Optical();
	$plugin->run();
}
run_woo_optical();
