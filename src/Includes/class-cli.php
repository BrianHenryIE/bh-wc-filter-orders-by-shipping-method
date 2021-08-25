<?php
/**
 * Add API methods to CLI.
 *
 * * update_cache: `wp filter_shipping_methods update_cache`
 *
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 * @package    BH_WC_Filter_Orders_By_Shipping_Method
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;
use WP_CLI_Command;

/**
 * Class CLI
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes
 */
class CLI extends WP_CLI_Command {

	/**
	 * The main plugin methods.
	 *
	 * @var API_Interface
	 */
	protected API_Interface $api;

	/**
	 * CLI constructor.
	 *
	 * @param API_Interface $api The main plugin functions.
	 */
	public function __construct( API_Interface $api ) {
		parent::__construct();
		$this->api = $api;
	}

	/**
	 * Force update the cache of shipment method titles.
	 *
	 * `wp filter_shipping_methods update_cache`
	 *
	 * @param string[] $args The command line arguments passed.
	 */
	public function update_cache( array $args ): void {

		$result = $this->api->update_shipping_methods_cache();

		// TODO: echo success.
	}

}
