<?php
/**
 * The file that adds the actions and filters to WordPress.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 * @package    BH_WC_Filter_Orders_By_Shipping_Method
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler\Scheduler;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce\Orders_List_Page;
use WP_CLI;

/**
 * The core plugin class that defines the hooks for WordPress to fire.
 *
 * @since      1.0.0
 * @package    BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @subpackage BrianHenryIE\WC_Filter_Orders_By_Shipping_Method/includes
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class BH_WC_Filter_Orders_By_Shipping_Method {

	/**
	 * A class implementing the main plugin functions.
	 *
	 * @var API_Interface
	 */
	protected API_Interface $api;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param API_Interface $api The object implementing the main plugin functions.
	 */
	public function __construct( API_Interface $api ) {

		$this->api = $api;

		$this->set_locale();
		$this->define_orders_list_page_hooks();
		$this->define_scheduler_hooks();
		$this->define_cli_commands();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	protected function set_locale(): void {

		$plugin_i18n = new I18n();

		add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );
	}

	/**
	 * Hooks for the shop order list page.
	 * `/wp-admin/edit.php?post_type=shop_order`
	 *
	 * Add the filter UI dropdown.
	 * Run the filter when it is used.
	 *
	 * @since    1.0.0
	 */
	protected function define_orders_list_page_hooks(): void {

		$orders_list_page = new Orders_List_Page( $this->api );

		add_action( 'restrict_manage_posts', array( $orders_list_page, 'print_filter_orders_by_shipping_method_ui' ) );
		add_filter( 'request', array( $orders_list_page, 'filter_orders_by_shipping_method_query' ) );
	}

	/**
	 * Action Scheduler hooks.
	 *
	 * Schedules a daily update of the shipping methods' cache.
	 * Adds the action to handle running the background task.
	 *
	 * @since    1.0.0
	 */
	protected function define_scheduler_hooks(): void {

		$scheduler = new Scheduler( $this->api );

		add_action( 'init', array( $scheduler, 'schedule_daily_update' ) );
		add_action( Scheduler::UPDATE_HOOK_NAME, array( $scheduler, 'run_update_task' ) );

	}

	/**
	 * Add CLI command for purging cache.
	 */
	protected function define_cli_commands(): void {

		if ( ! class_exists( WP_CLI::class ) ) {
			return;
		}

		$cli = new CLI( $this->api );

		try {
			WP_CLI::add_command( 'filter_shipping_methods', array( $cli, 'update_cache' ) );
		} catch ( \Exception $exception ) {
			WP_CLI::error( 'Failed to register filter_shipping_methods commands: ' . $exception->getMessage() );
		}
	}
}
