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


function justTestinDev() {
    if ( is_user_logged_in() ) {
      //echo ABSPATH . '<';
      //echo hash_file('md5', ABSPATH . 'lisenssi.html');
      //echo hash_file('sha1', ABSPATH . 'lisenssi.html');
      //print_r( scandir( ABSPATH ) );
      //$allHashFiles = createFileTree( ABSPATH );
      //echo count( $allHashFiles, COUNT_RECURSIVE );
      //echo json_encode($allHashFiles);
      
      //var_dump( is_dir( '/var/www/vhosts/toisenasteen.fi/httpdocs/wp-admin/' ) );
      //print_r( testAlgos( 'ojoij90jiojIOJjij ioj ij)j9009j0jj21j j 91 ', 10000 ) );
      
      /*
  $fullScan = new FileTree; // create new FileTree
  if( $fullScan->setPath( ABSPATH . 'wp-content/plugins/selusta-outpost' ) ) { // set path, ABSPATH is wordpress path
    if( $fullScan->setAlgo( 'sha1' ) ) { // if you want set algo for hashes
      $tree = $fullScan->create( ); // create new scan (this can take time)
      if( is_array( $tree ) ) { // check did scan success
        echo ' Files: ' . $fullScan->numberOfFiles;
        echo ' Folders: ' . $fullScan->numberOfFolders;
        echo ' Hashes: ' . $fullScan->numberOfHash;
        
        //print_r($tree);
        echo json_encode($tree);
      }
    }
  }
      
      */
      //echo ABSPATH;
      //var_dump(hash_file( 'md5', ABSPATH . 'robots.txt' ));
      //echo substr(sprintf('%o', fileperms( ABSPATH . 'wp-content/uploads/2017/09/Suomi100_kudvituskuosit_vaaka_1_RGB-001.jpg' )), -4);
      //print_r( stat(  ABSPATH . 'wp-content/uploads/2017/09/Suomi100_kuvituskuosit_vaaka_1_RGB-001.jpg' ) );
    }
}
add_action( 'init', 'justTestinDev');

/*
  ### Activation, deactivation & uninstall hooks ###
*/
register_activation_hook( __FILE__, 'selustaActivate' );
register_deactivation_hook( __FILE__, 'selustaDeActivate' );
register_uninstall_hook( __FILE__, 'selustaUnistall');

/*
  ### Menu items ###
*/
add_action( 'admin_menu', 'selustaMenuItems');
add_action( 'admin_footer', 'menuAppAssets' );

add_action( 'admin_enqueue_scripts', 'SelustaAdminEnqueue' );


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
