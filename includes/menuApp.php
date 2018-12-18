<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

function menuAppAssets() {
    echo '<script type="text/javascript">
      SelustaAssestsLocation = "' . plugin_dir_url() . 'selusta-outpost' . get_option( 'selusta-plugin-dir' ) . '/dist/";
    </script>';
}

?>