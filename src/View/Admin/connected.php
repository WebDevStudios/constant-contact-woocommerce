<?php 
    $url = admin_url( 'admin.php?page=' . esc_attr( $_GET['page'] ) );
    $url = add_query_arg( array(
        'cc-connect' => 'connected',
    ), $url );
    $dash_url = 'https://login.constantcontact.com/login/?goto=https%3A%2F%2Fapp.constantcontact.com%2Fpages%2Fecomm%2Fdashboard%23woocommerce';

?>

<div class="cc-woo-welcome-wrap"> 
    <div class="container">
        <div class="cc-woo-top-logo">
            <img class="cc-logo-main" src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/ctct.png'?>" />
        </div>
        <img class="cc-logo-main" src="<?php echo plugin_dir_url( __FILE__ ) . '../../assets/ctct-connected.png'?>" />
        <h1> <?php esc_html_e( 'Your store is connected to Constant Contact!', 'cc-woo' ); ?> </h1>
        <p><?php esc_html_e( 'If you want to disconnect constant contact from your store please go to the settings page.', 'cc-woo' ); ?></p>
        <div class="btn-wrap">
            <a href="<?php echo esc_url( $url ); ?>" class="cc-woo-btn btn-alternate"> <?php esc_html_e( "Edit Store Settings", 'cc-woo' ); ?> </a>
            <a href="<?php echo esc_url( $dash_url ); ?>" class="cc-woo-btn btn-connected"> <?php esc_html_e( "Constant Contact Dashboard", 'cc-woo' ); ?> </a>
        </div>
    </div>
</div>