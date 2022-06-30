<?php 
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
    $url = add_query_arg( array(
        'cc-connect' => 'connected',
    ), $url );
    $dash_url = 'https://login.constantcontact.com/login/?goto=https%3A%2F%2Fapp.constantcontact.com%2Fpages%2Fecomm%2Fdashboard%23woocommerce';

?>
<div class="cc-woo-welcome-wrap"> 
    <div class="container">
        <img class="cc-logo-main" src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/ctct.png'?>" />
        <h1> <?php echo esc_html__( 'Constant Contact for WooCommerce' ); ?> </h1>
        <p><?php echo esc_html__( 'Looks like you have not connected your account yet, You will first need to enter the information required in order to connect your account. If you have any issues connecting please call Constant Contact Support', 'cc-woo');?></p>
        <a href="<?php echo esc_url( $url ); ?>" class="cc-woo-btn btn-alternate"> <?php _e( "Edit Store Settings", 'cc-woo' ); ?> </a>
        <a href="<?php echo esc_url( $dash_url ); ?>" class="cc-woo-btn btn-primary"> <?php _e( "Constant Contact Dashboard", 'cc-woo' ); ?> </a>
    </div>
</div>