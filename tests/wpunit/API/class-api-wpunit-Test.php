<?php

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API;

/**
 * Class API_WPUnit_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API
 */
class API_WPUnit_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * @covers ::update_shipping_methods_cache
	 */
	public function test_update_shipping_methods_cache_get_values_from_db() {

		delete_transient( API::SHIPPING_METHODS_TRANSIENT_NAME );

		$order = new \WC_Order();

		$order_shipping = new \WC_Order_Item_Shipping();
		$order_shipping->set_name( 'Shipping Name 1' );

		$order->add_item( $order_shipping );

		$order->save();

		$sut = new API();

		$result = $sut->update_shipping_methods_cache();

		$this->assertNotEmpty( $result );

		$this->assertEquals( 'Shipping Name 1', $result[0] );

	}

	/**
	 * @covers ::update_shipping_methods_cache
	 */
	public function test_update_shipping_methods_cache_set_transient() {

		delete_transient( API::SHIPPING_METHODS_TRANSIENT_NAME );

		$order = new \WC_Order();

		$order_shipping = new \WC_Order_Item_Shipping();
		$order_shipping->set_name( __FUNCTION__ );

		$order->add_item( $order_shipping );

		$order->save();

		$sut = new API();

		$sut->update_shipping_methods_cache();

		$result = get_transient( API::SHIPPING_METHODS_TRANSIENT_NAME );

		$this->assertNotEmpty( $result );

		$this->assertEquals( __FUNCTION__, $result[0] );

	}

	/**
	 * @covers ::get_shipping_methods
	 */
	public function test_get_shipping_methods_from_transient() {

		delete_transient( API::SHIPPING_METHODS_TRANSIENT_NAME );

		add_filter(
			'pre_transient_' . API::SHIPPING_METHODS_TRANSIENT_NAME,
			function( $return_value, $transient ) {

				return array( 'shipping method from transient' );
			},
			10,
			2
		);

		$sut = new API();

		$result = $sut->get_shipping_methods();

		$this->assertNotEmpty( $result );

		$this->assertArrayHasKey( 'shipping-method-from-transient', $result );

		$this->assertEquals( 'shipping method from transient', array_pop( $result ) );

	}

	/**
	 * @covers ::get_shipping_methods
	 */
	public function test_get_shipping_methods_without_transient() {

		$this->markTestIncomplete( 'How to test the db was called?' );

		delete_transient( API::SHIPPING_METHODS_TRANSIENT_NAME );

		// Expect wpdb will be called.

		$sut = new API();

		$result = $sut->get_shipping_methods();

	}

	/**
	 * @covers ::get_order_ids_for_shipping_method
	 */
	public function test_get_order_ids_for_shipping_method() {

		$order          = new \WC_Order();
		$order_shipping = new \WC_Order_Item_Shipping();
		$order_shipping->set_name( 'Shipping Title' );
		$order->add_item( $order_shipping );
		$order_id_1 = $order->save();

		$order_2          = new \WC_Order();
		$order_shipping_2 = new \WC_Order_Item_Shipping();
		$order_shipping_2->set_name( 'Shipping Title' );
		$order_2->add_item( $order_shipping_2 );
		$order_id_2 = $order_2->save();

		$sut = new API();

		$result = $sut->get_order_ids_for_shipping_method( 'Shipping Title' );

		$this->assertCount( 2, $result );

		$this->assertContains( $order_id_1, $result );
		$this->assertContains( $order_id_2, $result );

	}

}
