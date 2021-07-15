<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           BrianHenryIE\WC_Filter_Orders_By_Shipping_Method
 *
 * @wordpress-plugin
 * Plugin Name:       BH WC Filter Orders By Shipping Method
 * Plugin URI:        http://github.com/username/bh-wc-filter-orders-by-shipping-method/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            BrianHenryIE
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-wc-filter-orders-by-shipping-method
 * Domain Path:       /languages
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\Activator;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\Deactivator;
use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\Includes\BrianHenryIE\WC_Filter_Orders_By_Shipping_Method;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BH_WC_FILTER_ORDERS_BY_SHIPPING_METHOD_VERSION', '1.0.0' );

register_activation_hook( __FILE__, array( Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( Deactivator::class, 'deactivate' ) );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_bh_wc_filter_orders_by_shipping_method(): BrianHenryIE\WC_Filter_Orders_By_Shipping_Method {

	$plugin = new BrianHenryIE\WC_Filter_Orders_By_Shipping_Method();

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['bh_wc_filter_orders_by_shipping_method'] = $bh_wc_filter_orders_by_shipping_method = instantiate_bh_wc_filter_orders_by_shipping_method();
