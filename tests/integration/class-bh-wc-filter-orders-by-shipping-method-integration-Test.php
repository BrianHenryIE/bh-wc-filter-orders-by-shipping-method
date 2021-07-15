<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\BrianHenryIE\WC_Filter_Orders_By_Shipping_Method;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Integration_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'bh_wc_filter_orders_by_shipping_method', $GLOBALS );

		$this->assertInstanceOf( BrianHenryIE\WC_Filter_Orders_By_Shipping_Method::class, $GLOBALS['bh_wc_filter_orders_by_shipping_method'] );
	}

}
