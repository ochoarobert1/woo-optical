<?php

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Woo_Optical
 * @subpackage Woo_Optical/includes
 * @author     Artness Company <info@artnessco.cl>
 */

class Woo_Optical_Loader
{
	protected $actions;
	protected $filters;
	protected $shortcodes;

	/**
	 * Method __construct
	 *
	 * @return void
	 */
	public function __construct()
	{

		$this->actions = array();
		$this->filters = array();
		$this->shortcodes = array();
	}

	/**
	 * Method add_action
	 *
	 * @param $hook $hook [explicite description]
	 * @param $component $component [explicite description]
	 * @param $callback $callback [explicite description]
	 * @param $priority $priority [explicite description]
	 * @param $accepted_args $accepted_args [explicite description]
	 *
	 * @return void
	 */
	public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
	{
		$this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
	}

	/**
	 * Method add_filter
	 *
	 * @param $hook $hook [explicite description]
	 * @param $component $component [explicite description]
	 * @param $callback $callback [explicite description]
	 * @param $priority $priority [explicite description]
	 * @param $accepted_args $accepted_args [explicite description]
	 *
	 * @return void
	 */
	public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
	{
		$this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
	}

	/**
	 * Method add
	 *
	 * @param $hooks $hooks [explicite description]
	 * @param $hook $hook [explicite description]
	 * @param $component $component [explicite description]
	 * @param $callback $callback [explicite description]
	 * @param $priority $priority [explicite description]
	 * @param $accepted_args $accepted_args [explicite description]
	 *
	 * @return void
	 */
	private function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
	{

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;
	}

	/**
	 * Method add_shortcode
	 *
	 * @param $hook $hook [explicite description]
	 * @param $component $component [explicite description]
	 * @param $callback $callback [explicite description]
	 * @param $priority $priority [explicite description]
	 * @param $accepted_args $accepted_args [explicite description]
	 *
	 * @return void
	 */
	public function add_shortcode($hook, $component, $callback, $priority = 10, $accepted_args = 1)
	{
		$this->shortcodes = $this->add($this->shortcodes, $hook, $component, $callback, $priority, $accepted_args);
	}

	/**
	 * Method run
	 *
	 * @return void
	 */
	public function run()
	{

		foreach ($this->filters as $hook) {
			add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
		}

		foreach ($this->actions as $hook) {
			add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
		}

		foreach ($this->shortcodes as $hook) {
			add_shortcode($hook['hook'], array($hook['component'], $hook['callback']));
		}
	}
}
