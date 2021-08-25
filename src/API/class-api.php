<?php
/**
 * Implementation of the main plugin functions.
 * i.e. database calls to fetch and cache shipping method titles, and the desired order ids.
 *
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 * @package    BH_WC_Filter_Orders_By_Shipping_Method
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API;

/**
 * Class API
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API
 *
 * phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery
 */
class API implements API_Interface {

	/**
	 * `wp transient get bh_wc_filter_orders_by_shipping_method_methods_list`
	 */
	const SHIPPING_METHODS_TRANSIENT_NAME = 'bh_wc_filter_orders_by_shipping_method_methods_list';

	/**
	 * Get the shipping methods to display in the orders list page filter drop-down.
	 *
	 * @return array<string, string> The shipping methods titles, keyed by their url friendly slugs.
	 */
	public function get_shipping_methods(): array {

		$shipping_method_titles = get_transient( self::SHIPPING_METHODS_TRANSIENT_NAME );

		if ( empty( $shipping_method_titles ) ) {
			$shipping_method_titles = $this->update_shipping_methods_cache();
		}

		$shipping_method_slugs = array_map( 'sanitize_title', $shipping_method_titles );

		return array_combine( $shipping_method_slugs, $shipping_method_titles );
	}

	/**
	 *
	 * This is going to get all shipping titles from ever used.
	 * `SELECT DISTINCT(order_item_name) FROM `wp_woocommerce_order_items` WHERE order_item_type = 'shipping'`
	 *
	 * TODO: Get titles that have yet to be used, i.e. after a new shipping method is added, need to be able to see there are 0 orders.
	 * TODO: Order most recently used first.
	 * TODO: Does transient time need to be configurable? Log it?!
	 * TODO: It would be nice to have aliases for shipping methods, i.e. a shorter list of titles, choose one, it searches for the three that are the "same" method.
	 *
	 * Sets a transient with a 25 hour expiry.
	 *
	 * NB This table is not indexed.
	 *
	 * @see https://github.com/woocommerce/woocommerce/wiki/Database-Description#table-woocommerce_order_items
	 *
	 * @return string[]
	 */
	public function update_shipping_methods_cache(): array {

		$cached_methods = wp_cache_get( 'cache' . self::SHIPPING_METHODS_TRANSIENT_NAME );

		if ( false !== $cached_methods && is_array( $cached_methods ) ) {
			return $cached_methods;
		}

		global $wpdb;

		$limit = 5;

		$results = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT(order_item_name) FROM {$wpdb->prefix}woocommerce_order_items WHERE order_item_type = 'shipping' ORDER BY order_id DESC LIMIT %d", $limit ), ARRAY_N );

		$methods = array_merge( ...$results );

		set_transient( self::SHIPPING_METHODS_TRANSIENT_NAME, $methods, DAY_IN_SECONDS + 3600 );

		wp_cache_set( 'cache' . self::SHIPPING_METHODS_TRANSIENT_NAME, $methods );

		return $methods;
	}

	/**
	 * The main search function. Queries the database for the ids of orders whose shipping line item name matches.
	 *
	 * NB: This query is not indexed.
	 * TODO: Add a limit and order desc by order_id.
	 *
	 * @see \WC_Order_Item_Shipping::get_name()
	 * @see WC_Order_Item_Shipping_Data_Store
	 *
	 * @param string $shipping_method The shipping method title to search for.
	 * @return int[]
	 */
	public function get_order_ids_for_shipping_method( string $shipping_method ): array {

		// idempotent.
		$shipping_method_slug = sanitize_title( $shipping_method );

		$cached_results = wp_cache_get( $shipping_method_slug );

		if ( false !== $cached_results && is_array( $cached_results ) ) {
			return $cached_results;
		}

		$shipping_methods = $this->get_shipping_methods();

		$shipping_method_title = $shipping_methods[ $shipping_method_slug ];

		global $wpdb;
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT order_id FROM {$wpdb->prefix}woocommerce_order_items WHERE order_item_name = %s", $shipping_method_title ), ARRAY_N );

		$order_ids = array_merge( ...$results );

		$order_ids = array_map( 'intval', $order_ids );

		wp_cache_set( $shipping_method_slug, $order_ids );

		return $order_ids;
	}
}
