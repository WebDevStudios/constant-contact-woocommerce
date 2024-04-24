<?php
/**
 * WooCommerce Checkout Block Newsletter
 * @since   NEXT
 * @author  Michael Beckwith <michael@webdevstudios.com>
 * @package cc-woo
 */

namespace WebDevStudios\CCForWoo\Utility;

use WebDevStudios\CCForWoo\Meta\ConnectionStatus;

/**
 * Tests if WooCommerce is available and compatible.
 * @since 0.0.1
 */
class CheckoutBlockNewsletter {

	/**
	 * The classname we'll be using for compatibility testing.
	 * @since 0.0.1
	 * @var string
	 */
	private $classname = '';

	public static $namespace = 'wc/cc-woo';

	public function add_newsletter_to_checkout_block() {

		$connection = new ConnectionStatus();
		if ( ! $connection->is_connected() ) {
			return;
		}

		$block_args = $this->get_newsletter_checkout_block_args();
		if ( function_exists( 'woocommerce_blocks_register_checkout_field' ) ) {
			woocommerce_blocks_register_checkout_field(
				$block_args
			);
		} elseif ( function_exists( '__experimental_woocommerce_blocks_register_checkout_field' ) ) {
			__experimental_woocommerce_blocks_register_checkout_field(
				$block_args
			);
		}
	}

	private function get_newsletter_checkout_block_args() {
		$checkbox_location = get_option( 'cc_woo_store_information_checkbox_location', 'woocommerce_after_checkout_billing_form' );
		$location          = 'contact';
		if ( $checkbox_location === 'woocommerce_after_checkout_billing_form' ) {
			$location = 'address';
		}

		return [
			'id'       => self::$namespace . '/newsletter-signup',
			'label'    => 'Do you want to subscribe to our newsletter?',
			'location' => $location,
			'type'     => 'checkbox',
		];
	}
}
