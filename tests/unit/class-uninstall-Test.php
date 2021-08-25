<?php

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API;
use Codeception\Test\Unit;

class Uninstall_Test extends Unit {


	protected function setup() : void {
		parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}


	/**
	 * Verify the transient is deleted during uninstall.
	 */
	public function test_uninstall_deletes_transient() {

		if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
			define( 'WP_UNINSTALL_PLUGIN', true );
		}

		\WP_Mock::userFunction(
			'delete_transient',
			array(
				'args'  => array( 'bh_wc_filter_orders_by_shipping_method_methods_list' ),
				'times' => 1,
			)
		);

		global $plugin_root_dir;

		require $plugin_root_dir . '/uninstall.php';
	}

	/**
	 * Since uninstall cannot read static variables from other classes, the transient name is
	 * hardcoded into the uninstall routine. This test ensure nothing has changed and broken.
	 */
	public function test_transient_name_is_correct() {

		$this->assertEquals(
			'bh_wc_filter_orders_by_shipping_method_methods_list',
			API::SHIPPING_METHODS_TRANSIENT_NAME,
			'The delete_transient name neede to be changed to ' . API::SHIPPING_METHODS_TRANSIENT_NAME
		);
	}

}
