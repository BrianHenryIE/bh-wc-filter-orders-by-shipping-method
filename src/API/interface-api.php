<?php
/**
 * The primary functions needed by the plugin.
 *
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 * @package    BH_WC_Filter_Orders_By_Shipping_Method
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler\Scheduler;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\CLI;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce\Orders_List_Page;

/**
 * Interface API_Interface
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API
 */
interface API_Interface {

	/**
	 * Get the titles of WooCommerce orders' shipping methods.
	 *
	 * @used-by Orders_List_Page::print_filter_orders_by_shipping_method_ui()
	 *
	 * @return array<string, string>
	 */
	public function get_shipping_methods(): array;

	/**
	 * Get a list of order ids that used the named shipping method.
	 *
	 * @used-by Orders_List_Page::filter_orders_by_shipping_method_query()
	 *
	 * @param string $shipping_method The shipping method title (or sanitized title) to search for.
	 * @return int[]
	 */
	public function get_order_ids_for_shipping_method( string $shipping_method ) : array;

	/**
	 * Unconditionally refresh the cache of shipping method titles.
	 *
	 * @used-by Scheduler::run_update_task()
	 * @used-by CLI::update_cache()
	 *
	 * @return string[]
	 */
	public function update_shipping_methods_cache(): array;

}
