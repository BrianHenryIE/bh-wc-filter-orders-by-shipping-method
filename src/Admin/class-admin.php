<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @subpackage BrianHenryIE\WC_Filter_Orders_By_Shipping_Method/admin
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @subpackage BrianHenryIE\WC_Filter_Orders_By_Shipping_Method/admin
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class Admin {

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @hooked admin_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'bh-wc-filter-orders-by-shipping-method', plugin_dir_url( __FILE__ ) . 'css/bh-wc-filter-orders-by-shipping-method-admin.css', array(), BH_WC_FILTER_ORDERS_BY_SHIPPING_METHOD_VERSION, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @hooked admin_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'bh-wc-filter-orders-by-shipping-method', plugin_dir_url( __FILE__ ) . 'js/bh-wc-filter-orders-by-shipping-method-admin.js', array( 'jquery' ), BH_WC_FILTER_ORDERS_BY_SHIPPING_METHOD_VERSION, false );

	}

}
