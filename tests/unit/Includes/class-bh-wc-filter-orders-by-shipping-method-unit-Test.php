<?php
/**
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method_Unit_Name
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Admin\Admin;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Frontend\Frontend;
use WP_Mock\Matcher\AnyInstance;

/**
 * Class BrianHenryIE\WC_Filter_Orders_By_Shipping_Method_Unit_Test
 */
class BrianHenryIE\WC_Filter_Orders_By_Shipping_Method_Unit_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}

	// This is required for `'times' => 1` to be verified.
	protected function _tearDown() {
		parent::_tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers BrianHenryIE\WC_Filter_Orders_By_Shipping_Method::set_locale
	 */
	public function test_set_locale_hooked() {

		\WP_Mock::expectActionAdded(
			'plugins_loaded',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		new BrianHenryIE\WC_Filter_Orders_By_Shipping_Method();
	}

	/**
	 * @covers BrianHenryIE\WC_Filter_Orders_By_Shipping_Method::define_admin_hooks
	 */
	public function test_admin_hooks() {

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin::class ), 'enqueue_styles' )
		);

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin::class ), 'enqueue_scripts' )
		);

		new BrianHenryIE\WC_Filter_Orders_By_Shipping_Method();
	}

	/**
	 * @covers BrianHenryIE\WC_Filter_Orders_By_Shipping_Method::define_frontend_hooks
	 */
	public function test_frontend_hooks() {

		\WP_Mock::expectActionAdded(
			'wp_enqueue_scripts',
			array( new AnyInstance( Frontend::class ), 'enqueue_styles' )
		);

		\WP_Mock::expectActionAdded(
			'wp_enqueue_scripts',
			array( new AnyInstance( Frontend::class ), 'enqueue_scripts' )
		);

		new BrianHenryIE\WC_Filter_Orders_By_Shipping_Method();
	}

}
