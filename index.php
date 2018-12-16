<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
Plugin Name:  Selusta Outpost
Plugin URI:   https://selusta.com/outpost
Description:  Selusta Outpost Wordpress integration plugin, security first
Version:      20181018
Author:       Selusta
Author URI:   https://selusta.com/
License:
License URI:
Text Domain:
Domain Path:
*/

require_once( 'includes/includes.php' );

if( is_admin() ) {
  //echo ABSPATH . '<';
  //echo hash_file('md5', ABSPATH . 'lisenssi.html');
  //echo hash_file('sha1', ABSPATH . 'lisenssi.html');
  //print_r( scandir( ABSPATH ) );
  //print_r( createFileTree( ABSPATH, 'md5' ) );
  //var_dump( is_dir( '/var/www/vhosts/toisenasteen.fi/httpdocs/wp-admin/' ) );
}

/*
  ### Activation, deactivation & uninstall hooks ###
*/
register_activation_hook( __FILE__, 'selustaActivate' );
register_deactivation_hook( __FILE__, 'selustaDeActivate' );
register_uninstall_hook( __FILE__, 'selustaUnistall');

/*
  ### Menu items ###
*/
add_action('admin_menu', 'selustaMenuItems');





function selustaGeneratePage() {
    // check user capabilities
    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?= esc_html(get_admin_page_title()); ?></h1>

    </div>
    <?php
}


?>
