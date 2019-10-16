<?php
/**
 * Class to handle recovery of abandoned carts via URL.
 *
 * @author  Rebekah Van Epps <rebekah.vanepps@webdevstudios.com>
 * @package WebDevStudios\CCForWoo\Api
 * @since   2019-10-11
 */

namespace WebDevStudios\CCForWoo\Api;

use WebDevStudios\CCForWoo\Database\AbandonedCartsTable;
use WebDevStudios\CCForWoo\Database\AbandonedCartsData;
use WebDevStudios\OopsWP\Structure\Service;

/**
 * Class AbandonedCartsRecover
 *
 * @author  Rebekah Van Epps <rebekah.vanepps@webdevstudios.com>
 * @package WebDevStudios\CCForWoo\Database
 * @since   2019-10-11
 */
class AbandonedCartsRecover extends Service {

	/**
	 * Register hooks with WordPress.
	 *
	 * @author Rebekah Van Epps <rebekah.vanepps@webdevstudios.com>
	 * @since  2019-10-15
	 */
	public function register_hooks() {
		if ( ! empty( $_GET['recover-cart'] ) ) {
			add_action( 'wp_loaded', [ $this, 'recover_cart' ] );
		}
	}

	/**
	 * Generate cart recovery URL.
	 *
	 * @author Rebekah Van Epps <rebekah.vanepps@webdevstudios.com>
	 * @since  2019-10-11
	 * @param  int $cart_id ID of abandoned cart.
	 * @return mixed           Cart recovery URL on successful retrieval, void on failure.
	 */
	public function get_cart_url( $cart_id ) {
		$cart_hash = AbandonedCartsData::get_cart_data(
			'HEX(cart_hash)',
			'cart_id = %d',
			[
				intval( $cart_id ),
			]
		);

		if ( null === $cart_hash ) {
			return;
		}

		return add_query_arg(
			'recover-cart',
			$cart_hash,
			get_site_url()
		);
	}

	/**
	 * Recovery saved cart from ID.
	 *
	 * @author Rebekah Van Epps <rebekah.vanepps@webdevstudios.com>
	 * @since  2019-10-15
	 * @return void
	 */
	public function recover_cart() {
		$cart_hash = sanitize_key( $_GET['recover-cart'] );

		if ( '' === $cart_hash ) {
			return;
		}

		// Clear current cart contents.
		WC()->cart->empty_cart();

		// Get saved cart contents.
		$cart_contents = AbandonedCartsData::get_cart_data(
			'cart_contents',
			'cart_hash = UNHEX(%s)',
			[
				$cart_hash,
			]
		);

		if ( null === $cart_contents ) {
			return;
		}

		// Programmatically add each product to cart.
		$products_added = [];
		foreach ( $cart_contents['products'] as $product ) {
			$added = WC()->cart->add_to_cart(
				$product['product_id'],
				$product['quantity'],
				empty( $product['variation_id'] ) ? 0 : $product['variation_id'],
				empty( $product['variation'] ) ? array() : $product['variation']
			);
			if ( false !== $added ) {
				$products_added[ ( empty( $product['variation_id'] ) ? $product['product_id'] : $product['variation_id'] ) ] = $product['quantity'];
			}
		}

		// Add product notices.
		if ( 0 < count( $products_added ) ) {
			wc_add_to_cart_message( $products_added );
		}
		if ( count( $cart_contents['products'] ) > count( $products_added ) ) {
			wc_add_notice(
				sprintf(
					/* translators: %d item count */
					_n(
						'%d item from your previous order is currently unavailable and could not be added to your cart.',
						'%d items from your previous order are currently unavailable and could not be added to your cart.',
						( count( $cart_contents['products'] ) - count( $products_added ) ),
						'cc-woo'
					),
					( count( $cart_contents['products'] ) - count( $products_added ) )
				),
				'error'
			);
		}

		// Apply coupons.
		foreach ( $cart_contents['coupons'] as $coupon ) {
			WC()->cart->apply_coupon( $coupon );
		}

		// Update customer info.
		foreach ( $cart_contents['customer']['billing'] as $key => $value ) {
			call_user_func(
				[ WC()->customer, "set_billing_{$key}" ],
				$value
			);
		}
		foreach ( $cart_contents['customer']['shipping'] as $key => $value ) {
			call_user_func(
				[ WC()->customer, "set_shipping_{$key}" ],
				$value
			);
		}

		// Apply shipping method.
		WC()->session->set( 'chosen_shipping_methods', $cart_contents['shipping_method'] );

		// Update totals.
		WC()->cart->calculate_totals();
		WC()->cart->calculate_shipping();

		// Redirect to cart page.
		wp_safe_redirect( wc_get_page_permalink( 'cart' ) );
		exit();
	}
}
