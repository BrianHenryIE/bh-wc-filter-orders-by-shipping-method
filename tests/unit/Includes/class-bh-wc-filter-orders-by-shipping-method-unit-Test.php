<?php
/**
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method_Unit_Name
 * @author  BrianHenryIE <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler\Scheduler;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Admin\Admin;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Frontend\Frontend;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce\Orders_List_Page;
use WP_Mock\Matcher\AnyInstance;

/**
 * Class BrianHenryIE\WC_Filter_Orders_By_Shipping_Method_Unit_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\BH_WC_Filter_Orders_By_Shipping_Method
 */
class BH_WC_Filter_Orders_By_Shipping_Method_Unit_Test extends \Codeception\Test\Unit {

	protected function setup(): void {
		\WP_Mock::setUp();
	}

	// This is required for `'times' => 1` to be verified.
	protected function tearDown(): void {
		parent::_tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::__construct
	 */
	public function test_construct(): void {

		$api = $this->makeEmpty( API_Interface::class );
		new BH_WC_Filter_Orders_By_Shipping_Method( $api );
	}

	/**
	 * @covers ::set_locale
	 */
	public function test_set_locale_hooked() {

		\WP_Mock::expectActionAdded(
			'plugins_loaded',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		$api = $this->makeEmpty( API_Interface::class );
		new BH_WC_Filter_Orders_By_Shipping_Method( $api );
	}

	/**
	 * @covers ::define_orders_list_page_hooks
	 */
	public function test_orders_list_page_hooks() {

		\WP_Mock::expectActionAdded(
			'restrict_manage_posts',
			array( new AnyInstance( Orders_List_Page::class ), 'print_filter_orders_by_shipping_method_ui' )
		);

		\WP_Mock::expectFilterAdded(
			'request',
			array( new AnyInstance( Orders_List_Page::class ), 'filter_orders_by_shipping_method_query' )
		);

		$api = $this->makeEmpty( API_Interface::class );
		new BH_WC_Filter_Orders_By_Shipping_Method( $api );
	}


	/**
	 * @covers ::define_scheduler_hooks
	 */
	public function test_scheduler_hooks() {

		\WP_Mock::expectActionAdded(
			'init',
			array( new AnyInstance( Scheduler::class ), 'schedule_daily_update' )
		);

		\WP_Mock::expectActionAdded(
			Scheduler::UPDATE_HOOK_NAME,
			array( new AnyInstance( Scheduler::class ), 'run_update_task' )
		);

		$api = $this->makeEmpty( API_Interface::class );
		new BH_WC_Filter_Orders_By_Shipping_Method( $api );
	}


}
