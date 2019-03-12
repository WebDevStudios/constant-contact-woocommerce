<?php
/**
 * WooCommerce Compatibility Class
 *
 * Tests to see if WooCommerce is available and compatible.
 *
 * @since 0.0.1
 * @author Zach Owen <zach@webdevstudios.com>
 * @package cc-woo
 */

namespace WebDevStudios\CCForWoo\Utility;

use \WebDevStudios\CCForWoo\Utility\PluginCompatibility;

/**
 * Tests if WooCommerce is available and compatible.
 *
 * @since 0.0.1
 */
class PluginCompatibilityCheck extends PluginCompatibility {
	/**
	 * The minimum WooCommerce version.
	 *
	 * @since 0.0.1
	 * @var string
	 */
	const MINIMUM_WOO_VERSION = '3.5.4';

	/**
	 * Check whether WooCommerce is available.
	 *
	 * @since 0.0.1
	 * @author Zach Owen <zach@webdevstudios.com>
	 * @return bool
	 */
	public function is_available() : bool {
		return class_exists( $this->classname );
	}

	/**
	 * Check whether WooCommerce is compatible
	 *
	 * @since 0.0.1
	 * @author Zach Owen <zach@webdevstudios.com>
	 * @param object $instance An instance of the WooCommerce class.
	 * @return bool
	 */
	public function is_compatible( $instance ) : bool {
		return 0 >= version_compare( self::MINIMUM_WOO_VERSION, $instance->version );
	}
}