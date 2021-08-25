<?php

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;

/**
 * Class Orders_List_Page_Unit_Test
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce\Orders_List_Page
 */
class Orders_List_Page_Unit_Test extends \Codeception\Test\Unit {

	/**
	 * The filter should add the order ids found by API class to the WordPress query.
	 *
	 * @covers ::filter_orders_by_shipping_method_query
	 */
	public function test_filter_request() {

		global $typenow;
		$typenow = 'shop_order';

		$_GET['_wpnonce']                                     = 'array key exists';
		$_GET[ Orders_List_Page::SHOP_ORDER_SHIPPING_METHOD ] = 'isset';

		$api = $this->makeEmpty(
			API_Interface::class,
			array(
				'get_order_ids_for_shipping_method' => array( 1, 2, 3 ),
			)
		);

		\WP_Mock::userFunction(
			'wp_verify_nonce',
			array(
				'return' => 1,
			)
		);

		\WP_Mock::userFunction(
			'wp_unslash',
			array(
				'return_arg' => true,
			)
		);

		\WP_Mock::userFunction(
			'sanitize_key',
			array(
				'return_arg' => true,
			)
		);

		\WP_Mock::userFunction(
			'sanitize_title',
			array(
				'return_arg' => true,
			)
		);

		$sut = new Orders_List_Page( $api );

		$vars = array();

		$result = $sut->filter_orders_by_shipping_method_query( $vars );

		$this->assertArrayHasKey( 'post__in', $result );

		$order_ids = $result['post__in'];

		$this->assertContains( 1, $order_ids );
		$this->assertContains( 2, $order_ids );
		$this->assertContains( 3, $order_ids );
	}

	/**
	 * @throws \Exception
	 *
	 * @covers ::filter_orders_by_shipping_method_query
	 */
	public function test_filter_returns_early_on_wrong_page() {

		global $typenow;

		$typenow = 'anything_else';

		// Gotta give the APi method some data to test against.
		$api = $this->makeEmpty(
			API_Interface::class,
			array(
				'get_order_ids_for_shipping_method_slug' => array( 1 ),
			)
		);

		$sut = new Orders_List_Page( $api );

		$vars = array();

		$result = $sut->filter_orders_by_shipping_method_query( $vars );

		$this->assertArrayNotHasKey( 'post__in', $result );

	}

	/**
	 * @covers ::filter_orders_by_shipping_method_query
	 */
	public function test_filter_returns_early_on_orders_page_without_filter_set() {

		global $typenow;

		$typenow = 'shop_order';

		// Gotta give the APi method some data to test against.
		$api = $this->makeEmpty(
			API_Interface::class,
			array(
				'get_order_ids_for_shipping_method_slug' => array( 1 ),
			)
		);

		$sut = new Orders_List_Page( $api );

		$vars = array();

		$result = $sut->filter_orders_by_shipping_method_query( $vars );

		$this->assertArrayNotHasKey( 'post__in', $result );

	}
}
