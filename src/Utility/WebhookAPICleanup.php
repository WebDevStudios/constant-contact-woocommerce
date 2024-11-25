<?php
/**
 * WooCommerce Webhook and API cleanup.
 *
 * @since   NEXT
 * @author  WebDevStudios.
 * @package cc-woo
 */

namespace WebDevStudios\CCForWoo\Utility;

/**
 * Webhook and API cleanup class.
 *
 * @since NEXT
 */
class WebhookAPICleanup {

	/**
	 * WPDB class instance.
	 *
	 * @var \WPDB $wpdb
	 */
	protected \WPDB $wpdb;

	/**
	 * Constructor.
	 *
	 * @param \WPDB $wpdb
	 */
	public function __construct( \WPDB $wpdb) {
		$this->wpdb = $wpdb;
	}

	/**
	 * Clear out all of our webhooks by name.
	 *
	 * @since NEXT
	 */
	public function clear_webhooks() {
		$query = "DELETE FROM {$this->wpdb->prefix}wc_webhooks WHERE topic = '%s'";
		$result = $this->wpdb->query(
			$this->wpdb->prepare(
				$query,
				'action.wc_ctct_disconnect'
			)
		);
	}

	/**
	 * Clear out all of our API connections.
	 *
	 * @since NEXT
	 */
	public function clear_api_connections() {
		$query  = "DELETE FROM {$this->wpdb->prefix}woocommerce_api_keys WHERE description LIKE 'Constant Contact - API%'";
		$result = $this->wpdb->query(
			$query
		);
	}
}
