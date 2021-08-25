<?php

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;
use Codeception\Stub\Expected;

/**
 * Class Scheduler_Test
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler\Scheduler
 */
class Scheduler_Test extends \Codeception\Test\Unit {

	protected function setup() : void {
		parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	public function test_schedule_daily_update() {

		$api = $this->makeEmpty( API_Interface::class );

		\WP_Mock::userFunction(
			'as_next_scheduled_action',
			array(
				'args'   => array( Scheduler::UPDATE_HOOK_NAME ),
				'times'  => 1,
				'return' => false,
			)
		);

		if ( ! defined( 'DAY_IN_SECONDS' ) ) {
			define( 'DAY_IN_SECONDS', 60 * 60 * 24 );
		}

		\WP_Mock::userFunction(
			'as_schedule_recurring_action',
			array(
				'args'  => array( \WP_Mock\Functions::type( 'int' ), DAY_IN_SECONDS, Scheduler::UPDATE_HOOK_NAME ),
				'times' => 1,
			)
		);

		$sut = new Scheduler( $api );

		$sut->schedule_daily_update();
	}


	public function test_update_calls_api_update_method() {

		$api = $this->makeEmpty(
			API_Interface::class,
			array(
				'update_shipping_methods_cache' => Expected::once(
					function() {
						return array();}
				),
			)
		);

		$sut = new Scheduler( $api );

		$sut->run_update_task();

	}

}
