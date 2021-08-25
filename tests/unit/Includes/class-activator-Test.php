<?php

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler\Scheduler;

/**
 * Class Activator_Test
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\Activator
 */
class Activator_Test extends \Codeception\Test\Unit {

	protected function setup() : void {
		parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	/**
	 * @covers ::activate
	 */
	public function test_activation_should_add_init_action_to_schedule() {

		\WP_Mock::expectActionAdded(
			'init',
			array( Activator::class, 'schedule_immediate_cache_update' )
		);

		Activator::activate();

	}

	/**
	 * @covers ::schedule_immediate_cache_update
	 */
	public function test_add_action_scheduler_action() {

		\WP_Mock::userFunction(
			'as_schedule_single_action',
			array(
				'args'  => array( \WP_Mock\Functions::type( 'int' ), Scheduler::UPDATE_HOOK_NAME ),
				'times' => 1,
			)
		);

		Activator::schedule_immediate_cache_update();
	}

}
