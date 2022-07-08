<?php 
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
    $url = add_query_arg( array(
        'cc-connect' => 'connect',
    ), $url );    
?>
<div class="cc-woo-welcome-wrap"> 
    <div class="container">
        <img class="cc-logo-main" src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/ctct.png'?>" />
        <h1> 
            <?php esc_html_e( 'Constant Contact for WooCommerce' ); ?> 
        </h1>
        <p>
            <?php esc_html_e( 'Looks like you have not connected your account yet, You will first need to enter the information required in order to connect your account. If you have any issues connecting please call Constant Contact Support', 'cc-woo'); ?>
        </p>
        <a href="<?php echo esc_url( $url ); ?>" class="cc-woo-btn btn-primary"> <?php _e( "Let's Start", 'cc-woo' ); ?> </a>
    </div>
</div>