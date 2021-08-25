<?php
/**
 * Add a UI on the admin orders list page view for selecting shipping method.
 *
 * @author     BrianHenryIE <BrianHenryIE@gmail.com>
 * @package    BH_WC_Filter_Orders_By_Shipping_Method
 */

namespace BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce;

use BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\API\API_Interface;

/**
 * Class Orders_List_Page
 *
 * @package BrianHenryIE\WC_Filter_Orders_By_Shipping_Method\WooCommerce
 */
class Orders_List_Page {

	const SHOP_ORDER_SHIPPING_METHOD = '_shop_order_shipping_method';

	/**
	 * The main plugin functions.
	 *
	 * @var API_Interface
	 */
	protected API_Interface $api;

	/**
	 * Orders_List_Page constructor.
	 *
	 * @param API_Interface $api The main plugin functions.
	 */
	public function __construct( API_Interface $api ) {
		$this->api = $api;
	}

	/**
	 * Add select option on orders screen for selecting domestic/international.
	 *
	 * @hooked restrict_manage_posts
	 * @see WP_Posts_List_Table::extra_tablenav()
	 *
	 * @since 1.0.0
	 *
	 * Disabling nonce requirement so links to this filter can be shared.
     * phpcs:disable WordPress.Security.NonceVerification.Recommended
	 */
	public function print_filter_orders_by_shipping_method_ui(): void {
		global $typenow;

		if ( 'shop_order' !== $typenow ) {
			return;
		}

		// TODO: Add filter so old ones can be removed from the list.
		$shipping_methods = $this->api->get_shipping_methods();

		?>
		<select name="_shop_order_shipping_method" id="dropdown_shop_order_shipping_method">
			<option value="">
				<?php esc_html_e( 'All Shipping Methods', 'bh-wc-filter-orders-by-shipping-method' ); ?>
			</option>

			<?php foreach ( $shipping_methods as $shipping_method_slug => $shipping_method_title ) : ?>
				<option value="<?php echo esc_attr( $shipping_method_slug ); ?>" <?php echo esc_attr( isset( $_GET[ self::SHOP_ORDER_SHIPPING_METHOD ] ) ? selected( $shipping_method_slug, sanitize_title( wp_unslash( $_GET[ self::SHOP_ORDER_SHIPPING_METHOD ] ) ), false ) : '' ); ?>>
					<?php echo esc_html( $shipping_method_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<?php
	}

	/**
	 * Process bulk filter order payment method
	 *
	 * @hooked request
	 *
	 * @see WP::parse_request()
	 * @see https://luetkemj.github.io/wp-query-ref/
	 *
	 * @since 1.0.0
	 *
	 * @param array<string, mixed> $vars query vars without filtering.
	 * @return array<string, mixed> $vars query vars with (maybe) filtering.
	 */
	public function filter_orders_by_shipping_method_query( array $vars ): array {
		global $typenow;

		if ( 'shop_order' !== $typenow ) {
			return $vars;
		}

		if ( ! array_key_exists( '_wpnonce', $_GET ) ) {
			return $vars;
		}

		// TODO not 100% sure on sanitizing action like this.
		$action = ! array_key_exists( 'action', $_GET ) ? -1 : sanitize_title( wp_unslash( $_GET['action'] ) );

		if ( ! wp_verify_nonce( wp_unslash( sanitize_key( $_GET['_wpnonce'] ) ), $action ) ) {
			return $vars;
		}

		if ( ! isset( $_GET[ self::SHOP_ORDER_SHIPPING_METHOD ] ) ) {
			return $vars;
		}

		$shipping_method_slug = sanitize_title( wp_unslash( $_GET[ self::SHOP_ORDER_SHIPPING_METHOD ] ) );

		if ( empty( $shipping_method_slug ) ) {
			return $vars;
		}

		$order_ids = $this->api->get_order_ids_for_shipping_method( $shipping_method_slug );

		if ( ! isset( $vars['post__in'] ) ) {
			$vars['post__in'] = $order_ids;
		} else {
			$vars['post__in'] = array_unique( array_merge( $vars['post__in'], $order_ids ) );
		}

		return $vars;
	}

}
