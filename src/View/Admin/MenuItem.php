<?php
/**
 * Adds a the Constant Contact menu item to the WooCommerce menu.
 *
 * @since 2019-04-16
 * @package ccforwoo-view-admin
 */

namespace WebDevStudios\CCForWoo\View\Admin;

use WebDevStudios\OopsWP\Structure\Service;

/**
 * MenuItem Class
 *
 * @since 2019-04-16
 * @version 0.0.1
 */
class MenuItem extends Service {
	/**
	 * Register WP hooks.
	 *
	 * @since 0.0.1
	 * @author Zach Owen <zach@webdevstudios>
	 */
	public function register_hooks() {
		add_action( 'admin_menu', [ $this, 'add_cc_woo_admin_submenu' ], 100 );
		add_action( 'admin_menu', [ $this, 'add_cc_woo_admin_menu' ], 100 );
	}

	public function add_cc_woo_admin_menu() {
		add_menu_page(
			__( 'Constant Contact', 'cc-woo' ),
			__( 'Constant Contact', 'cc-woo' ),
			'manage_options',
			'ctct-woo-settings',
			[$this, 'cctct_standalone_settings_page_contents'],
			'dashicons-email',
			56
		);
	}
	
	public function cctct_standalone_settings_page_contents() {
		\WC_Admin_Settings::get_settings_pages();
		$woo = new \WebDevStudios\CCForWoo\View\Admin\WooTab();
		woocommerce_admin_fields( $woo->get_welcome_screen() );
	}

	/**
	 * Add the CC Woo Submenu Item.
	 *
	 * @since 0.0.1
	 * @author Zach Owen <zach@webdevstudios>
	 */
	public function add_cc_woo_admin_submenu() {
		add_submenu_page(
			'woocommerce',
			esc_html__( 'Constant Contact', 'cc-woo' ),
			esc_html__( 'Constant Contact', 'cc-woo' ),
			'manage_woocommerce',
			'cc-woo-settings',
			[ $this, 'redirect_to_cc_woo' ]
		);
	}

	/**
	 * Redirect the user to the CC-Woo options page.
	 *
	 * @since 0.0.1
	 * @author Zach Owen <zach@webdevstudios>
	 */
	public function redirect_to_cc_woo() {
		wp_safe_redirect( admin_url( 'admin.php?page=wc-settings&tab=cc_woo' ) );
		exit;
	}
}
