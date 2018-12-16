<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function selustaActivate() { // First time activation plugin
  // Create unique id for folder

  // checking folder name
  $folderName = substr( __DIR__ , -15);
  if( $folderName !== 'selusta-outpost' ) {
    // return if name different then 'selusta-outpost'
    return;
  }

  // generating random string to Selusta plugin folder
  $randMax = getrandmax();
  $rand = rand( round( $randMax, - strlen( $randMax ) + 1 ), $randMax );
  if( function_exists( 'hash' ) ) {
    $uniqid = hash('md5', uniqid() . $rand );
  } else {
    $uniqid = md5( uniqid() . $rand );
  }

  // Change plugin folder name add uniqid
  $renameFolder = rename( __DIR__ , __DIR__ . '-' . $uniqid );
  if( $renameFolder ) { // if folder name change success

    $plugin_file = 'selusta-outpost' . $uniqid . '/index.php';
    $newPluginInstallationUrl = html_entity_decode( wp_nonce_url( 'plugins.php?action=activate&plugin=' . urlencode( $plugin_file ) . '&plugin_status=all&paged=1&s=', 'activate-plugin_' . $plugin_file ) );
    if ( wp_redirect( $newPluginInstallationUrl ) ) {
      exit; // if redirect success
    } else { // force redirect
      header('Location: ' . $newPluginInstallationUrl );
      exit;
    }

  } else { // if folder name change fail

  }




}

function selustaDeInstall() {

}

function selustaUnistall() {

}
 ?>
