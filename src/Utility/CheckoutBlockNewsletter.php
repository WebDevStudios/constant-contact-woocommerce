<?php
/**
 * WooCommerce Checkout Block Newsletter
 * @since   NEXT
 * @author  Michael Beckwith <michael@webdevstudios.com>
 * @package cc-woo
 */

namespace WebDevStudios\CCForWoo\Utility;

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
		$checkbox_location = get_option( 'cc_woo_store_information_checkbox_location', 'woocommerce_after_checkout_billing_form' );
		$location          = 'contact';
		if ( $checkbox_location === 'woocommerce_after_checkout_billing_form' ) {
			$location = 'address';
		}
		if ( function_exists( 'woocommerce_blocks_register_checkout_field' ) ) {
			woocommerce_blocks_register_checkout_field(
				[
					'id'       => self::$namespace . '/newsletter-signup',
					'label'    => 'Do you want to subscribe to our newsletter?',
					'location' => $location,
					'type'     => 'checkbox',
				]
			);
		}
		__experimental_woocommerce_blocks_register_checkout_field(
			[
				'id'       => self::$namespace . '/newsletter-signup',
				'label'    => esc_html__( 'HIGH FIVE Sign me up to receive marketing emails', 'constant-contact-woocommerce' ),
				'location' => $location,
				'type'     => 'checkbox',
			]
		);
	}
}
