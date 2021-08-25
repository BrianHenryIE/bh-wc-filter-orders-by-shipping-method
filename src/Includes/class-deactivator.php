<?php
/**
 * Fired during plugin deactivation
 *
 * Removes the scheduled cache update.
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
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 * @subpackage BrianHenryIE\WC_Filter_Orders_By_Shipping_Method/includes
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 */
class Deactivator {

	/**
	 * Removes the scheduled cache update.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate(): void {

		if ( function_exists( 'as_unschedule_all_actions' ) ) {
			as_unschedule_all_actions( Scheduler::UPDATE_HOOK_NAME );
		}

	}

}
