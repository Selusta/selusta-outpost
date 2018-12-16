<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/* createFileTree create file tree with sub folders
  Ex.
  wp-admin
    css
      about
      about-rtl.css
      about-rtl.min.css
      about.css
   	images
   	includes
   	js
   	maint
    about.php
    admin-ajax.php
    admin-footer.php
  wp-content
  wp-includes
  index.php
  readme.txt
  wp-config.php
  ...
*/

function createFileTree( $path = true, $hash = false ) {

  if( $path === true || is_dir( $path ) === false ) { // if 'path' not set return false
    return false;                                     // or 'path' is not dir
  }

  if( $hash !== false ) {
    $hashProt = array(
      'md5',
      'sha1'
    );
    if( in_array( $hash, $hashProt ) ) {
      $prot = $hash;
      $hash = true;
    }
  }



  if( substr( $path, -1 ) !== '/' ) {
    $path = $path . '/';
  }

  $result = scandir( $path );
  if( $result[0] === '.' && $result[1] === '..' ) {
    array_splice($result, 0, 2);
  } else {
    if( $result[0] === '.' ) {
      array_splice($result, 1);
    }
    if( $result[1] === '..' ) {
      array_splice($result, 1);
    }
  }


  foreach ($result as $key => $value) {
      if( is_dir( $path . $value ) ) {
        if( $hash ) {
          $result[$key] = array(
            $value => createFileTree( $path . $value, $prot )
          );
        } else {
          $result[$key] = array(
            $value => createFileTree( $path . $value )
          );
        }
      } else {
        if( $hash ) {
          $result[$key] = array (
            $value => hash_file( $prot, $path . $value )
          );
        }
      }
  }

  return $result;

}

?>
