<?php
/**
 * Handle background updating of cache.
 *
 * Transient is presumed to last 25 hours and be scheduled to be refreshed every 24.
 *
 * @see https://actionscheduler.org/
 *
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 * @package    BH_WC_Filter_Orders_By_Shipping_Method
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;

/**
 * Use Action Scheduler to update the cache of shipping method titles.
 *
 * Class Scheduler
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Scheduler
 */
class Scheduler {

	const UPDATE_HOOK_NAME = 'bh_wc_filter_orders_by_shipping_method_update';

	/**
	 * The plugin's main functions.
	 *
	 * @var API_Interface $api
	 */
	protected API_Interface $api;

	/**
	 * Scheduler constructor.
	 *
	 * @see API_Interface::update_shipping_methods_cache()
	 *
	 * @param API_Interface $api The plugin's main functions.
	 */
	public function __construct( API_Interface $api ) {
		$this->api = $api;
	}

	/**
	 * Register the cache-refresh job with Action Scheduler.
	 *
	 * @hooked init
	 *
	 * This would be nicer hooked to an `actionscheduler_init` hook and removing the `function_exists`.
	 * @see https://github.com/woocommerce/action-scheduler/issues/749
	 */
	public function schedule_daily_update(): void {

		if ( ! function_exists( 'as_next_scheduled_action' ) ) {
			return;
		}

		if ( false === as_next_scheduled_action( self::UPDATE_HOOK_NAME ) ) {
			as_schedule_recurring_action( strtotime( 'tomorrow' ), DAY_IN_SECONDS, self::UPDATE_HOOK_NAME );
		}
	}

	/**
	 * Calls the API method to update the cache of shipping method titles.
	 * This function is hooked to the action that Action Scheduler (cron) will call.
	 *
	 * @hooked bh_wc_filter_orders_by_shipping_method_update_task
	 */
	public function run_update_task(): void {
		$this->api->update_shipping_methods_cache();
	}

}
