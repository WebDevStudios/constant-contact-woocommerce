<?php
/**
 * THIS NEEDS WORK AND CONFIRMATION OF WHAT ALL SHOULD BE IN THIS BEFORE WE SHIP.
 */
namespace WebDevStudios\CCForWoo\Rest\ConnectionStatus;

/**
 * Class ConnectionStatus\Schema
 *
 * @package WebDevStudios\CCForWoo\Rest\PluginVersion
 * @since   NEXT
 */
class Schema {

	/**
	 * Get the Connection Status schema for public consumption.
	 *
	 * @since  NEXT
	 *
	 * @author WebDevStudios <contact@webdevstudios.com>
	 *
	 * @return array
	 */
	public static function get_public_item_schema() {
		return [
			'$schema'    => 'https://json-schema.org/draft-04/schema#',
			'title'      => 'cc_woo_connection_status',
			'type'       => 'object',
			'properties' => [
				'connection_status' => [
					'description' => esc_html__( 'The current Constant Contact connection status.', 'constant-contact-woocommerce' ),
					'type'        => 'string',
				],
			],
		];
	}
}
