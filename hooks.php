<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function selustaActivate() { // First time activation plugin
  // Create unique id for folder

  $folderName = substr( __DIR__ , -15);
  if( $folderName !== 'selusta-outpost' ) {
    return;
  }
  $uniqid = uniqid( '-' );

  // Change plugin folder name add uniqid
  $renameFolder = rename( __DIR__ , __DIR__ . $uniqid );
  if( $renameFolder ) { // if folder name change success

    // change value to 'active_plugins' option
    $activePlugins = get_option( 'active_plugins' );
    if( is_array( $activePlugins ) ) { // if 'active_plugins' return array
      // search selusta plugin line from array
      $activeSelustaPluginKey = array_search( 'selusta-outpost/index.php', $activePlugins );
      if( is_numeric( $activeSelustaPluginKey ) ) {
        // Add uniqid to 'active_plugins'
        $activePlugins[ $activeSelustaPluginKey ] = 'selusta-outpost' . $uniqid . '/index.php';
        // Update Plugin
        $updateActivePlugins = update_option( 'active_plugins', $activePlugins );
        if( $updateActivePlugins ) { // if 'active_plugins' option update success

        } else { // if 'active_plugins' option update fail

        }
      } else { // Selusta is not set in 'active_plugins'

      }
    } else { // if 'active_plugins' return fail

    } // end of 'active_plugins' update

    // change value to 'uninstall_plugins' option
    $uninstallPlugins = get_option( 'uninstall_plugins' );
    if( is_array( $uninstallPlugins ) ) { // if 'uninstall_plugins' return array

      // check does Selusta exists in array
      if( array_key_exists( 'selusta-outpost/index.php', $uninstallPlugins) ) {
        // add new row to array and delete old one
        $uninstallPlugins['selusta-outpost' . $uniqid . '/index.php'] = $uninstallPlugins['selusta-outpost/index.php'];
        unset($uninstallPlugins['selusta-outpost/index.php']);

        $updateUninstallPlugins = update_option( 'uninstall_plugins', $uninstallPlugins );
        if( $updateUninstallPlugins ) { // if 'uninstall_plugins' option update success

        } else { // if 'uninstall_plugins' option update fail

        }
      } else { // Selusta does not exist in array

      }

    } else { // if get 'uninstall_plugins' fail

    } // end of 'uninstall_plugins' update

    // update key to 'recently_activated' option
    $recentlyActivated = get_option( 'recently_activated' );
    if( is_array( $recentlyActivated ) ) { // if 'recently_activated' success

      // check does Selusta exist in 'recently_activated'
      if( array_key_exists( 'selusta-outpost/index.php', $recentlyActivated ) ) {
        // add new row to array and delete old one
        $recentlyActivated['selusta-outpost' . $uniqid . '/index.php'] = $recentlyActivated['selusta-outpost/index.php'];
        unset($recentlyActivated['selusta-outpost/index.php']);

        $updateRecentlyActivated = update_option( 'recently_activated', $recentlyActivated );
        if( $updateRecentlyActivated ) { // if 'recently_activated' option update success

        } else { // if 'recently_activated' option update fail

        }
      } else { // Selusta does not exists in array

      }

    } else { // if 'recently_activated' not array = fails

    } // end of 'recently_activated' update

    $siteUpdatePlugins = get_option( '_site_transient_update_plugins' );
    if( is_object($siteUpdatePlugins) ) { //if '_site_transient_update_plugins' success

      // does Selusta exists in 'checked' array
      if( array_key_exists( 'selusta-outpost/index.php', $siteUpdatePlugins->checked ) ) {
        $siteUpdatePlugins->checked['selusta-outpost' . $uniqid . '/index.php'] = $siteUpdatePlugins->checked['selusta-outpost/index.php'];
        unset($siteUpdatePlugins->checked['selusta-outpost/index.php']);

        $updateSiteUpdatePlugins = update_option( '_site_transient_update_plugins', $siteUpdatePlugins );
        if( $updateSiteUpdatePlugins ) { // if '_site_transient_update_plugins' option update success

        } else { // if '_site_transient_update_plugins' option update fail

        }
      } else { // Selusta does not exists

      }

    } // end of '_site_transient_update_plugins' update

    $pluginSlugs = get_option( '_transient_plugin_slugs' );
    if( is_array( $pluginSlugs ) ) { // if '_transient_plugin_slugs' success

      $SelustaRow = array_search( 'selusta-outpost/index.php', $pluginSlugs );
      if( is_numeric( $SelustaRow ) ) { // if Selusta found
        $pluginSlugs[$SelustaRow] = 'selusta-outpost' . $uniqid . '/index.php';

        $updatePluginSlugs = update_option( '_transient_plugin_slugs', $pluginSlugs );
        if( $updatePluginSlugs ) { // if '_transient_plugin_slugs' option update success

        } else { // if '_transient_plugin_slugs' option update fail

        }

      } else { // Selusta does not exits

      }
    } // end of '_transient_plugin_slugs' update

    $plugin_file = 'selusta-outpost' . $uniqid . '/index.php';
    header('Location: ' . html_entity_decode(wp_nonce_url( 'plugins.php?action=activate&plugin=' . urlencode( $plugin_file ) . '&plugin_status=all&paged=1&s=', 'activate-plugin_' . $plugin_file )) );
    exit;


  } else { // if folder name change fail

  }




}

function selustaDeInstall() {

}

function selustaUnistall() {

}
 ?>
