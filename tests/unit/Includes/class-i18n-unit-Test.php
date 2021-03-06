<?php
/**
 *
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

/**
 * Class Plugin_WP_Mock_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\I18n
 */
class I18n_Unit_Test extends \Codeception\Test\Unit {

	protected function setup() : void {
		parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	/**
	 * Verify load_plugin_textdomain is correctly called.
	 *
	 * @covers ::load_plugin_textdomain
	 */
	public function test_load_plugin_textdomain() {

		global $plugin_root_dir;

		\WP_Mock::userFunction(
			'plugin_basename',
			array(
				'args'   => array(
					\WP_Mock\Functions::type( 'string' ),
				),
				'return' => 'bh-wc-filter-orders-domestic-international',
				'times'  => 1,
			)
		);

		\WP_Mock::userFunction(
			'load_plugin_textdomain',
			array(
				'times' => 1,
				'args'  => array(
					'bh-wc-filter-orders-by-shipping-method',
					false,
					\WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$i18n = new I18n();
		$i18n->load_plugin_textdomain();
	}
}
