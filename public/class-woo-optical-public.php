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


	// Agrega la tabla de valores a los productos
	public function woo_optical_add_custom_table()
	{
		global $product;

		// Verifica que el producto sea de tipo "variable"
		if ($product && $product->is_type('variable')) {
			echo '<table class="custom-optics-table">';
			echo '<tr><th>Montura</th><th>Tipo de lente</th><th>Valores</th></tr>';

			// Obtén las opciones de montura y tipo de lente del producto
			$montura_options = get_post_meta($product->get_id(), 'woo_optical_montura', true);
			$lente_options = get_post_meta($product->get_id(), 'woo_optical_lente', true);

			// Itera sobre las opciones y genera las filas de la tabla
			foreach ($montura_options as $montura) {
				foreach ($lente_options as $lente) {
					echo '<tr>';
					echo '<td class="custom-optics-montura">' . $montura . '</td>';
					echo '<td class="custom-optics-lente">' . $lente . '</td>';
					echo '<td><input type="number" name="woo_optical_values[' . $montura . '_' . $lente . ']" min="0" step="1" /></td>';
					echo '</tr>';
				}
			}

			echo '</table>';
		}
	}


	// Actualiza el precio y el inventario del producto
	public function woo_optical_update_product($cart_object)
	{
		foreach ($cart_object->get_cart_contents() as $cart_item_key => $cart_item) {
			$product = $cart_item['data'];
			$product_id = $product->get_id();
			$product_price = $product->get_price();
			$custom_values = isset($_POST['woo_optical_values']) ? $_POST['woo_optical_values'] : array();

			// Verifica si se han ingresado valores personalizados
			if (!empty($custom_values) && $product->is_type('variation')) {
				// Obtén los valores personalizados del producto
				$montura = $product->get_attribute('montura');
				$lente = $product->get_attribute('lente');
				$value_key = $montura . '_' . $lente;

				// Verifica si los valores personalizados coinciden
				if (isset($custom_values[$value_key])) {
					$custom_value = $custom_values[$value_key];

					// Actualiza el inventario del producto
					wc_update_product_stock($product_id, $custom_value, 'decrease');

					// Actualiza el precio del producto
					$product->set_price($product_price + $custom_value);
				}
			}
		}
	}

	
}
