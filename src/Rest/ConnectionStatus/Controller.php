<?php

// NEED TO ADHERE TO CONTROLLER PATTERN https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#the-controller-pattern

namespace WebDevStudios\CCForWoo\Rest\ConnectionStatus;

use WebDevStudios\CCForWoo\Utility\DebugLogging;
use WebDevStudios\CCForWoo\Meta\ConnectionStatus as MetaConnection;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Controller;
use WP_REST_Response;
use WP_Error;

use WebDevStudios\CCForWoo\Plugin;
use WebDevStudios\CCForWoo\Rest\Registrar;

/**
 * Class ConnectionStatus\Controller
 * @package WebDevStudios\CCForWoo\Rest\PluginVersion
 * @since   NEXT
 */
class Controller extends WP_REST_Controller {

	/**
	 * This endpoint's rest base.
	 *
	 * @since NEXT
	 *
	 * @var string
	 */
	protected $rest_base;

	public function __construct() {
		$this->rest_base = 'connection-status';
	}

	public function register_routes() {
		register_rest_route(
			Registrar::$namespace,
			'/' . $this->rest_base,
			[
				[
					'methods'             => WP_REST_Server::EDITABLE,
					'callback'            => [ $this, 'update_item' ],
					'args'                => [
						'param_1' => [
							'validate_callback' => function( $param, $request, $key ) {
								return true;
							},
							'sanitize_callback' => function( $param, $request, $key ) {
								return $param;
							}
						]
					],
					'permission_callback' => [ $this, 'get_item_permissions_check' ],
				],
				'schema' => [ '\WebDevStudios\CCForWoo\Rest\ConnectionStatus\Schema', 'get_public_item_schema' ],
			]
		);
	}

	public function get_item_permissions_check( $request ) {
		// WE NEED TO AUTHENTICATE USER.
		if ( ! wc_rest_check_manager_permissions( 'settings', 'write' ) ) {

			$ctct_logger = new DebugLogging(
				wc_get_logger(),
				'CTCT Woo: no permission to update status',
				'warning',
				[ 'cc-woo-rest-not-allowed' => $request ]
			);
			$ctct_logger->log();

			return new WP_Error(
				'cc-woo-rest-not-allowed',
				esc_html__( 'Sorry, you cannot update connection status.', 'constant-contact-woocommerce' ),
				[ 'status' => rest_authorization_required_code() ]
			);
		}

		return true;
	}

	public function update_item( $request ) {

		// Do our things here.
		// Could have body properties.
		// If we have URL params, this will still work:
		$success = filter_input( INPUT_GET, 'success', FILTER_SANITIZE_NUMBER_INT );
		$user_id = filter_input( INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT );

		if ( is_null( $success ) || is_null( $user_id ) ) {
			// return an error
		}

		// You can get the combined, merged set of parameters:
		$parameters = $request->get_params();

		//$this->connection = new MetaConnection();
		//$this->connection->set_connection( $success, $user_id );

		$response = [
			'success' => true,
		];

		return new WP_REST_Response( $response, 200 );
	}
}

