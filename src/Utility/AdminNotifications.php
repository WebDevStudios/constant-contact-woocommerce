<?php

namespace WebDevStudios\CCForWoo\Utility;

use WebDevStudios\CCForWoo\Meta\ConnectionStatus;

/**
 * Class AdminNotifications
 */
class AdminNotifications {

	private $cc_woo_is_reviewed = 'cc-woo-is-reviewed';

	private $cc_woo_review_dismissed_count = 'cc-woo-review-dismissed-count';

	public function __construct() {

	}

	public function register_hooks() {
		add_action( 'admin_notices', [ $this, 'notification' ] );
		add_action( 'wp_ajax_cc_woo_increment_dismissed_count', [ $this, 'increment_dismissed_count' ] );
		add_action( 'wp_ajax_cc_woo_set_already_reviewed', [ $this, 'set_reviewed_status' ] );
	}

	public function notification() {

		if ( ! $this->should_notify() ) {
			return;
		}

		wp_admin_notice(
			sprintf(
				/* Translators: Placeholders here are for `<strong>` HTML and link tags. */
				esc_html__( 'You have been successfully using %1$sConstant Contact Woocommerce%2$s to capture valuable site visitor information! Please consider leaving us a %3$snice review%4$s. Reviews help fellow WordPress admins find our plugin and lets you provide us useful feedback. %5$sDismiss%6$s - %7$sI have already reviewed%8$s', 'constant-contact-forms' ),
				'<strong>',
				'</strong>',
				sprintf(
					'<a href="%s">',
					esc_url( 'https://wordpress.org/support/plugin/constant-contact-woocommerce/reviews/#new-post' )
				),
				'</a>',
				'<a id="cc-woo-review-dismiss" href="#">',
				'</a>',
				'<a id="already-reviewed" href="#">',
				'</a>'
			),
			[
				'type'        => 'notice',
				'dismissible' => true,
				'attributes'  => [ 'data-nonce' => wp_create_nonce( 'cc-woo-review-admin-notice' ) ],
				'id'          => 'cc-woo-review-dismiss',
			]
		);
	}

	private function should_notify() {

		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$connection = new ConnectionStatus();
		if ( ! $connection->is_connected() ) {
			return false;
		}

		$is_reviewed = get_option( $this->cc_woo_is_reviewed, 'false' );
		if ( 'true' === $is_reviewed ) {
			return false;
		}

		$activated_time = get_option( ConnectionStatus::CC_CONNECTED_TIME, '' );
		// we may not have an activation time. Make this one optional.
		if ( $activated_time ) {
			if ( time() < strtotime( '+14 days', $activated_time ) ) {
				return false;
			}
		}

		$dismissed_count = get_option( $this->cc_woo_review_dismissed_count, [] );
		if ( isset( $dismissed['count'] ) && '1' === $dismissed['count'] ) {
			$fourteen_days = strtotime( '-14 days' );

			if ( isset( $dismissed['time'] ) && $dismissed['time'] < $fourteen_days ) {
				return true;
			}

			return false;
		}

		if ( isset( $dismissed['count'] ) && '2' === $dismissed['count'] ) {
			$thirty_days = strtotime( '-30 days' );

			if ( isset( $dismissed['time'] ) && $dismissed['time'] < $thirty_days ) {
				return true;
			}

			return false;
		}

		if ( isset( $dismissed['count'] ) && '3' === $dismissed['count'] ) {
			$thirty_days = strtotime( '-90 days' );

			if ( isset( $dismissed['time'] ) && $dismissed['time'] < $thirty_days ) {
				return true;
			}

			return false;
		}

		if ( '4' === $dismissed_count['count'] ) {
			return false;
		}

		return true;
	}

	public function increment_dismissed_count() {
		if ( ! isset( $_REQUEST['action'] ) || 'increment_dismissed_count' !== sanitize_text_field( $_REQUEST['action' ] ) ) {
			return;
		}

		if ( empty( $_REQUEST['cc_woo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( $_REQUEST['cc_woo_nonce'] ), 'cc-woo-review-admin-notice' ) ) {
			wp_send_json_error( esc_html__( 'Invalid nonce.', 'constant-contact-woocommerce' ) );
		}

		$dismissed_count = get_option( $this->cc_woo_review_dismissed_count, [] );
		$dismissed_count['time'] = current_time('timestamp');

		if ( empty( $dismissed_count['count'] ) ) {
			$dismissed_count['count'] = '1';
		} elseif ( isset( $dismissed_count['count'] ) && '2' === $dismissed_count['count'] ) {
			$dismissed_count['count'] = '3';
		} elseif ( isset( $dismissed_count['count'] ) && '3' === $dismissed_count['count'] ) {
			$dismissed_count['count'] = '4';
		} else {
			$dismissed_count['count'] = '1';
		}
		update_option( $this->cc_woo_review_dismissed_count, $dismissed_count );

		$msg = '';
		if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			$msg = esc_html__( "Dismissed count incremented to {$dismissed_count['count']}", 'constant-contact-woocommerce' );
		}
		wp_send_json_success( $msg );
	}

	public function set_reviewed_status() {
		if ( ! isset( $_REQUEST['action'] ) || 'increment_dismissed_count' !== sanitize_text_field( $_REQUEST['action'] ) ) {
			return;
		}

		if ( empty( $_REQUEST['cc_woo_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( $_REQUEST['cc_woo_nonce'] ), 'cc-woo-review-admin-notice' ) ) {
			wp_send_json_error( esc_html__( 'Invalid nonce.', 'constant-contact-woocommerce' ) );
		}

		update_option( $this->cc_woo_is_reviewed, 'true' );

		$msg = '';
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$msg = esc_html__( 'Plugin marked as reviewed', 'constant-contact-woocommerce' );
		}
		wp_send_json_success( $msg );
	}
}
