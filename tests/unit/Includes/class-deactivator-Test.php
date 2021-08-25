<?php

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler\Scheduler;

/**
 * Class Deactivator_Test
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes
 * @coversDefaultClass \BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\Deactivator
 */
class Deactivator_Test extends \Codeception\Test\Unit {

	protected function setup() : void {
		parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	/**
	 * @covers ::deactivate
	 */
	public function test_deactivate_unregisters_schedulaed_task() {

		\WP_Mock::userFunction(
			'as_unschedule_all_actions',
			array(
				'args'  => array( Scheduler::UPDATE_HOOK_NAME ),
				'times' => 1,
			)
		);

		Deactivator::deactivate();

	}

}
