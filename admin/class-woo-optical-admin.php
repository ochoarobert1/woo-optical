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

	/**
	 * Method woo_optical_admin_menu
	 * Opens an admin page for entering prices
	 *
	 * @return void
	 */
	public function woo_optical_admin_menu()
	{
		add_menu_page(
			__('Eye Formulas Settings', 'woo-optical'),
			__('Price for Eye Formulas', 'woo-optical'),
			'manage_options',
			'custom-optics-settings',
			[$this, 'woo_optical_settings_page'],
			'dashicons-visibility',
			75
		);
	}

	/**
	 * Method woo_optical_settings_page
	 *
	 * @return void
	 */
	public function woo_optical_settings_page()
	{
		if (!current_user_can('manage_options')) {
			return;
		}

		if (isset($_GET['settings-updated'])) {
			add_settings_error('woo_optical_messages', 'woo_optical_message', __('Settings Saved', 'woo-optical'), 'updated');
		}

		settings_errors('woo_optical_messages');
?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields('woo_optical_prices');
				do_settings_sections('woo_optical_prices');
				submit_button(__('Save Settings', 'woo-optical'));
				?>
			</form>
		</div>
	<?php
	}

	/**
	 * Method woo_optical_prices_section_callback
	 *
	 * @return void
	 */
	public function woo_optical_prices_section_callback()
	{
		_e('Enter the prices for every combination ESF / CIL:', 'woo-optical');
	}

	/**
	 * Method woo_optical_price_matrix_field_callback
	 *
	 * @return void
	 */
	public function woo_optical_price_matrix_field_callback()
	{
		$price_matrix = get_option('woo_optical_price_matrix');
		$esf_values = range(-6.00, 6.00, 0.25);
		$cil_values = range(0.00, 6.00, 0.25);
	?>
		<table class="form-table">
			<tr>
				<th></th>
				<?php foreach ($cil_values as $cil) : ?>
					<th><?php echo $cil; ?></th>
				<?php endforeach; ?>
			</tr>
			<?php foreach ($esf_values as $esf) : ?>
				<tr>
					<th><?php echo $esf; ?></th>
					<?php foreach ($cil_values as $cil) : ?>
						<td>
							<?php
							$key = $this->woo_optical_get_price_matrix_key($esf, $cil);
							$value = isset($price_matrix[$key]) ? $price_matrix[$key] : '';
							?>
							<input type="number" step="any" name="woo_optical_price_matrix[<?php echo $key; ?>]" value="<?php echo $value; ?>">
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php
	}

	/**
	 * Method woo_optical_eje_section_callback
	 *
	 * @return void
	 */
	public function woo_optical_eje_section_callback()
	{
		_e('Enter the prices for every AXIS value:', 'woo-optical');
	}

	// Callback del campo de costos de EJE
	public function woo_optical_eje_cost_field_callback()
	{
		$eje_cost = get_option('woo_optical_eje_cost');
	?>
		<table class="form-table">
			<tr>
				<th><?php _e('Axis:', 'woo-optical'); ?></th>
				<th><?php _e('Price:', 'woo-optical'); ?></th>
			</tr>
			<tr>
				<td>0</td>
				<td><input type="number" step="any" name="woo_optical_eje_cost[0]" value="<?php echo isset($eje_cost[0]) ? $eje_cost[0] : ''; ?>"></td>
			</tr>
			<tr>
				<td>90</td>
				<td><input type="number" step="any" name="woo_optical_eje_cost[90]" value="<?php echo isset($eje_cost[90]) ? $eje_cost[90] : ''; ?>"></td>
			</tr>
			<tr>
				<td>180</td>
				<td><input type="number" step="any" name="woo_optical_eje_cost[180]" value="<?php echo isset($eje_cost[180]) ? $eje_cost[180] : ''; ?>"></td>
			</tr>
		</table>
	<?php
	}

	/**
	 * Method woo_optical_dp_section_callback
	 *
	 * @return void
	 */
	public function woo_optical_dp_section_callback()
	{
		_e('Enter the prices for every DP value', 'woo-optical');
	}

	/**
	 * Method woo_optical_dp_cost_field_callback
	 *
	 * @return void
	 */
	public function woo_optical_dp_cost_field_callback()
	{
		$dp_cost = get_option('woo_optical_dp_cost');
	?>
		<table class="form-table">
			<tr>
				<th><?php _e('DP:', 'woo-optical'); ?></th>
				<th><?php _e('Price:', 'woo-optical'); ?></th>
			</tr>
			<tr>
				<td><?php _e('DP1:', 'woo-optical'); ?></td>
				<td><input type="number" step="any" name="woo_optical_dp_cost[dp1]" value="<?php echo isset($dp_cost['dp1']) ? $dp_cost['dp1'] : ''; ?>"></td>
			</tr>
			<tr>
				<td><?php _e('DP2:', 'woo-optical'); ?></td>
				<td><input type="number" step="any" name="woo_optical_dp_cost[dp2]" value="<?php echo isset($dp_cost['dp2']) ? $dp_cost['dp2'] : ''; ?>"></td>
			</tr>
			<tr>
				<td><?php _e('DP3:', 'woo-optical'); ?></td>
				<td><input type="number" step="any" name="woo_optical_dp_cost[dp3]" value="<?php echo isset($dp_cost['dp3']) ? $dp_cost['dp3'] : ''; ?>"></td>
			</tr>
		</table>
<?php
	}

	/**
	 * Method woo_optical_get_price_matrix_key
	 *
	 * @param $esf $esf [explicite description]
	 * @param $cil $cil [explicite description]
	 *
	 * @return void
	 */
	public function woo_optical_get_price_matrix_key($esf, $cil)
	{
		return $esf . '_' . $cil;
	}

	/**
	 * Method woo_optical_register_settings
	 *
	 * @return void
	 */
	public function woo_optical_register_settings()
	{
		register_setting(
			'woo_optical_prices',
			'woo_optical_price_matrix'
		);

		add_settings_section(
			'woo_optical_prices_section',
			__('Price Matrix', 'woo-optical'),
			[$this, 'woo_optical_prices_section_callback'],
			'woo_optical_prices'
		);

		add_settings_field(
			'woo_optical_price_matrix_field',
			__('Prices', 'woo-optical'),
			[$this, 'woo_optical_price_matrix_field_callback'],
			'woo_optical_prices',
			'woo_optical_prices_section'
		);

		register_setting(
			'woo_optical_prices',
			'woo_optical_eje_cost'
		);

		add_settings_section(
			'woo_optical_eje_section',
			__('AXIS Prices', 'woo-optical'),
			[$this, 'woo_optical_eje_section_callback'],
			'woo_optical_prices'
		);

		add_settings_field(
			'woo_optical_eje_cost_field',
			__('AXIS Price', 'woo-optical'),
			[$this, 'woo_optical_eje_cost_field_callback'],
			'woo_optical_prices',
			'woo_optical_eje_section'
		);

		register_setting(
			'woo_optical_prices',
			'woo_optical_dp_cost'
		);

		add_settings_section(
			'woo_optical_dp_section',
			__('DP Prices', 'woo-optical'),
			[$this, 'woo_optical_dp_section_callback'],
			'woo_optical_prices'
		);

		add_settings_field(
			'woo_optical_dp_cost_field',
			__('DP Price', 'woo-optical'),
			[$this, 'woo_optical_dp_cost_field_callback'],
			'woo_optical_prices',
			'woo_optical_dp_section'
		);
	}

	/**
	 * Method woo_optical_report_shortcode
	 *
	 * @return void
	 */
	public function woo_optical_report_shortcode()
	{
		return '<a href="' . admin_url('admin-post.php?action=woo_optical_generate_report') . '">Download Sales Report</a>';
	}

	public function woo_optical_generate_sales_report()
	{
		global $wpdb;

		$table_name = $wpdb->prefix . 'woo_optical_sales_report';
		$results = $wpdb->get_results("SELECT customer_id, product_id, montura, lente, COUNT(*) as total_sales FROM $table_name GROUP BY customer_id, product_id, montura, lente");

		if (!empty($results)) {
			$html = '<table>';
			$html .= '<tr><th>Customer ID</th><th>Product ID</th><th>Montura</th><th>Lente</th><th>Total Sales</th></tr>';

			foreach ($results as $result) {
				$html .= '<tr>';
				$html .= '<td>' . $result->customer_id . '</td>';
				$html .= '<td>' . $result->product_id . '</td>';
				$html .= '<td>' . $result->montura . '</td>';
				$html .= '<td>' . $result->lente . '</td>';
				$html .= '<td>' . $result->total_sales . '</td>';
				$html .= '</tr>';
			}

			$html .= '</table>';

			// Descarga la tabla en formato Excel
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="sales_report.xls"');
			echo $html;
			exit();
		}
	}
}
