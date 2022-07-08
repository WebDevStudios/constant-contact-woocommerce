<?php 
// Handles the plugin disconnection.

namespace WebDevStudios\CCForWoo\View\Admin;
use WebDevStudios\OopsWP\Structure\Service;

/**
 * Disconnects the plugin from Constant Contact WOO.
 *
 * @since ??
 * @return void
 */
class Disconnect extends Service {
    
    /**
    * Constructor.
    *
    * @since ??
    * @return void
    */
    public function register_hooks() {
        add_action( 'admin_init', array( $this, 'disconnect' ) );
    }
    
    /**
    * Disconnects the plugin from Constant Contact WOO.
    *
    * @since ??
    * @return void
    */
    public function disconnect() {
        if ( ! isset( $_GET['cc-connect'] ) || 'disconnect' !== $_GET['cc-connect'] ) {
            return;
        }

        $this->disconnect_plugin();
        $this->redirect();
    }
    
    /**
    * Disconnects the plugin from Constant Contact WOO.
    *
    * @since ??
    * @return void
    */
    public function disconnect_plugin() {

        // Delete the plugin options.
        delete_option( 'cc_woo_customer_data_allow_import' );
        delete_option( 'cc_woo_customer_data_email_opt_in_default' );
        delete_option( 'cc_woo_store_information_checkbox_location' );
        delete_option( 'cc_woo_save_store_details' );
        delete_option( 'cc_woo_store_information_first_name' );
        delete_option( 'cc_woo_store_information_last_name' );
        delete_option( 'cc_woo_store_information_phone_number' );
        delete_option( 'cc_woo_store_information_store_name' );
        delete_option( 'cc_woo_store_information_contact_email' );
        delete_option( 'cc_woo_import_connection_established' );
        delete_option( 'cc_woo_api_user_id' );
        delete_option( 'cc_woo_first_connection' );
    }
    
    /**
    * Redirects to the admin page.
    *
    * @since ??
    * @return void
    */
    public function redirect() {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
        $url = remove_query_arg( [
            'cc-connect',
        ], $url );
        wp_redirect( $url );
        exit;
    }
}