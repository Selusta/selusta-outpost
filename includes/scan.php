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

  createFileTree ( path , algo )
*/

function createFileTree( $path = true, $hash = false ) {
  if( $path === true || is_dir( $path ) === false ) { // if 'path' not set return false
    return false;                                     // or 'path' is not dir
  }

  if( $hash !== false ) { // if hash set, checking is algo availeble
    if( in_array( $hash, hash_algos() ) ) {
      $algo = $hash;
      $hash = true;
    }
  }

  if( substr( $path, -1 ) !== '/' ) { // add '/' to end, if not already
    $path = $path . '/';
  }

  $result = scandir( $path );

  // delete all '.' and '..' result, regenerate key numbers
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

  // create file tree, open dirs and create hashes if set
  foreach ($result as $key => $value) {
      if( is_dir( $path . $value ) ) {
        if( $hash ) {
          $result[$key] = array( // open new dir
            $value => createFileTree( $path . $value, $algo )
          );
        } else {
          $result[$key] = array( // open new dir
            $value => createFileTree( $path . $value )
          );
        }
      } else {
        if( $hash ) { // if hash set, generate hash from file
          $result[$key] = array (
            $value => hash_file( $algo, $path . $value )
          );
        }
      }
  }

  return $result;

} // end of 'createFileTree' function

/*  testAlgos test all availeble algos
    testAlgos ( text , repeats )
    return array, with algo, time and result/hash
*/

function testAlgos( $text = 'Selusta', $repeats = 1 ) {
  $testResult = hash_algos(); // get all availeble algos
    foreach ( $testResult as $key => $algo) {
      $startTime = microtime(); // start microtime
      for ( $i = 0; $i <= $repeats ; $i++) {
        $hashResult =  hash( $algo, $text);
      }
      $endTime = microtime(); // end microtime
      $testResult[$key] = array(
        'algo' => $algo,
        'time' => $endTime - $startTime,
        'result' => $hashResult
      );
    }
    return $testResult;
} // end of 'testAlgos' function

?>
