<?php
/**
 * Tests for the root plugin file.
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\BH_WC_Filter_Orders_By_Shipping_Method;

/**
 * Class Plugin_WP_Mock_Test
 */
class Plugin_Unit_Test extends \Codeception\Test\Unit {

	protected function setup() : void {
		parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}


	/**
	 * Verifies the plugin initialization.
	 * Verifies the plugin does not output anything to screen.
	 */
	public function test_plugin_include() {

		// Prevents code-coverage counting, and removes the need to define the WordPress functions that are used in that class.
		\Patchwork\redefine(
			array( BH_WC_Filter_Orders_By_Shipping_Method::class, '__construct' ),
			function( $api ) {}
		);

		global $plugin_root_dir;

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		ob_start();

		require $plugin_root_dir . '/bh-wc-filter-orders-by-shipping-method.php';

		$printed_output = ob_get_clean();

		$this->assertEmpty( $printed_output );

		$this->assertArrayHasKey( 'bh_wc_filter_orders_by_shipping_method', $GLOBALS );

		$this->assertInstanceOf( API_Interface::class, $GLOBALS['bh_wc_filter_orders_by_shipping_method'] );

	}

}
