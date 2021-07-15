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

	protected function _before() {
		\WP_Mock::setUp();
	}

	// This is required for `'times' => 1` to be verified.
	protected function _tearDown() {
		parent::_tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * Verify load_plugin_textdomain is correctly called.
	 *
	 * @covers ::load_plugin_textdomain
	 */
	public function test_load_plugin_textdomain() {

		global $plugin_root_dir;

		\WP_Mock::userFunction(
			'load_plugin_textdomain',
			array(
                'times' => 1,
				'args'   => array(
					'bh-wc-filter-orders-by-shipping-method',
					false,
					$plugin_root_dir . '/languages/',
				)
			)
		);

        $i18n = new I18n();
        $i18n->load_plugin_textdomain();
	}
}
