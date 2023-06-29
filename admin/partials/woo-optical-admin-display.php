<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://artnesco.cl
 * @since      1.0.0
 *
 * @package    Woo_Optical
 * @subpackage Woo_Optical/admin/partials
 */

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