<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @subpackage BrianHenryIE\WC_Filter_Orders_By_Shipping_Method/frontend
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Frontend;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the frontend-facing stylesheet and JavaScript.
 *
 * @package    BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @subpackage BrianHenryIE\WC_Filter_Orders_By_Shipping_Method/frontend
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class Frontend {

	/**
	 * Register the stylesheets for the frontend-facing side of the site.
	 *
	 * @hooked wp_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		wp_enqueue_style( 'bh-wc-filter-orders-by-shipping-method', plugin_dir_url( __FILE__ ) . 'css/bh-wc-filter-orders-by-shipping-method-frontend.css', array(), BH_WC_FILTER_ORDERS_BY_SHIPPING_METHOD_VERSION, 'all' );

	}

	/**
	 * Register the JavaScript for the frontend-facing side of the site.
	 *
	 * @hooked wp_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {

		wp_enqueue_script( 'bh-wc-filter-orders-by-shipping-method', plugin_dir_url( __FILE__ ) . 'js/bh-wc-filter-orders-by-shipping-method-frontend.js', array( 'jquery' ), BH_WC_FILTER_ORDERS_BY_SHIPPING_METHOD_VERSION, false );

	}

}
