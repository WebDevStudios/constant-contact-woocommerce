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
		add_filter( 'woocommerce_get_default_value_for_' . self::$namespace . '/newsletter-signup', [ $this, 'set_default_value' ], 10, 3 );
	}

	public function add_newsletter_to_checkout_block() {

		$connection = new ConnectionStatus();
		if ( ! $connection->is_connected() ) {
			return;
		}

		$block_args = $this->get_newsletter_checkout_block_args();
		if ( function_exists( 'woocommerce_register_additional_checkout_field' ) ) {
			woocommerce_register_additional_checkout_field(
				$block_args
			);
		}
	}

	private function get_newsletter_checkout_block_args() {
		$checkbox_location = get_option( 'cc_woo_store_information_checkbox_location', 'woocommerce_after_checkout_billing_form' );
		$location          = 'order';
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

	public function sanitize_agreement_value( $value, $key ) {
		if ( self::$namespace . '/newsletter-signup' !== $key ) {
			return $value;
		}

		return (bool) $value;
	}

	public function set_agreement_value_on_object( $key, $value, $group, $wc_object ) {
		if ( self::$namespace . '/newsletter-signup' !== $key ) {
			return;
		}

		if ( $group !== 'billing' ) {
			return;
		}

		$wc_object->update_meta_data( self::CUSTOMER_PREFERENCE_META_FIELD, $value, true );

		// This filter is from WooCommerce Core.
		$customer_id = apply_filters( 'woocommerce_checkout_customer_id', get_current_user_id() );
		if ( ! $customer_id ) {
			return;
		}

		// No user created from customer. Nothing to save.
		update_user_meta( $customer_id, self::CUSTOMER_PREFERENCE_META_FIELD, $value );
	}

	private function get_store_default_checked_state(): bool {
		return 'true' === get_option( self::STORE_NEWSLETTER_DEFAULT_OPTION );
	}

	public function set_default_value( $value, $group, $wc_object ) {
		return $this->get_user_default_checked_state();
	}

	private function get_user_default_checked_state(): bool {
		$user_preference = get_user_meta( get_current_user_id(), self::CUSTOMER_PREFERENCE_META_FIELD, true );

		return ! empty( $user_preference ) ? 'true' === $user_preference : $this->get_store_default_checked_state();
	}
}
