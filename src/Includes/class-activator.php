<?php
/**
 * Fired during plugin activation
 *
 * Schedules the shipping method titles cache initialization to run asap.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 * @package    BH_WC_Filter_Orders_By_Shipping_Method
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\ActionScheduler\Scheduler;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @subpackage BrianHenryIE\WC_Filter_Orders_By_Shipping_Method/includes
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class Activator {

	/**
	 * Schedule one-off cron job to update shipping method titles cache.
	 *
	 * @since    1.0.0
	 */
	public static function activate(): void {

		add_action( 'init', array( self::class, 'schedule_immediate_cache_update' ) );
	}

	/**
	 * Schedule an immediate update of the cache, since the normal update schedule starts "tomorrow".
	 */
	public static function schedule_immediate_cache_update(): void {

		if ( ! function_exists( 'as_schedule_single_action' ) ) {
			return;
		}

		as_schedule_single_action( time(), Scheduler::UPDATE_HOOK_NAME );
	}

}
