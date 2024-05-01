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

	public static $namespace = 'wc/cc-woo';

	const CUSTOMER_PREFERENCE_META_FIELD = 'cc_woo_customer_agrees_to_marketing';

	const STORE_NEWSLETTER_DEFAULT_OPTION = 'cc_woo_customer_data_email_opt_in_default';

	public function register_hooks() {
		add_action( 'woocommerce_set_additional_field_value', [ $this, 'set_agreement_value_on_object' ], 10, 4 );
		add_action( 'woocommerce_sanitize_additional_field', [ $this, 'sanitize_agreement_value' ], 10, 2 );
		add_filter( 'woocommerce_blocks_get_default_value_for_' . self::$namespace . '/newsletter-signup', [ $this, 'set_default_value' ], 10, 3 );
	}

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
