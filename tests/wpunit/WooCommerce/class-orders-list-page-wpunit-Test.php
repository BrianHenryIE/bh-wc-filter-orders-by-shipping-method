<?php

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;

/**
 * Class Orders_List_Page_WPUnit_Test
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce\Orders_List_Page
 */
class Orders_List_Page_WPUnit_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Make sure there is no HTML outputted when we're not on a shop_order page.
	 *
	 * @covers ::print_filter_orders_by_shipping_method_ui
	 */
	public function test_print_filter_orders_by_shipping_method_ui_no_output_on_wrong_page() {

		global $typenow;

		$typenow = 'anything_else';

		$api = $this->makeEmpty( API_Interface::class );

		$sut = new Orders_List_Page( $api );

		ob_start();

		$sut->print_filter_orders_by_shipping_method_ui();

		$result = ob_get_clean();

		$this->assertEmpty( $result );

	}

}
