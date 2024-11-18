<?php

namespace WebDevStudios\CCForWoo\Utility;

class WebhookAPICleanup {

	protected \WPDB $wpdb;
	public function __construct( \WPDB $wpdb) {
		$this->wpdb = $wpdb;
	}
	public function clear_webhooks() {
		$query = "DELETE FROM {$this->wpdb->prefix}wc_webhooks WHERE topic = '%s'";
		$result = $this->wpdb->query(
			$this->wpdb->prepare(
				$query,
				'action.wc_ctct_disconnect'
			)
		);
	}

	public function clear_api_connections() {
		$query  = "DELETE FROM {$this->wpdb->prefix}woocommerce_api_keys WHERE description LIKE 'Constant Contact - API%'";
		$result = $this->wpdb->query(
			$query
		);

		$g = '';
	}
}
