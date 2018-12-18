<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class FileTree {
  
  // Let's make some statistic
  public $numberOfFiles = 0;
  public $numberOfFolders = 0;
  public $numberOfHash = 0;
  var $algo = false;
  var $treePath;
  
  function setPath( $path = true ) {
    
    if( $path === true || is_dir( $path ) === false ) { // if 'path' not set return false
      return false;                                     // or 'path' is not dir
    }

    $this->treePath = $path;
    
    return true;
  }
  
  function setAlgo( $algo = 'md5' ) {

      if( in_array( $algo, hash_algos() ) ) {
        $this->algo = $algo;
        return true;
      }
      return false;

  }
  
  function create( ) {
    
    // reset stats
    $this->numberOfFiles = 0;
    $this->numberOfFolders = 0;
    $this->numberOfHash = 0;
    
    $path = $this->treePath;
    $hash = false;
    
    if( $algo !== false ) {
      $algo = $this->algo;
      $hash = true;
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
        if( is_dir( $path . $value ) ) { // is folder/dir
          
          $this->numberOfFolders += 1;
          
          if( $hash ) {
            $result[$key] = array( // open new dir
              $value => $this->createArray( $path . $value, $algo )
            );
          } else {
            $result[$key] = array( // open new dir
              $value => $this->createArray( $path . $value )
            );
          }
          
        } else { // is file
          
          $this->numberOfFiles += 1;
          
          if( $hash ) { // if hash set, generate hash from file
            $result[$key] = $this->fileInfo( $path . $value, $algo );
          } else {
            $result[$key] = $this->fileInfo( $path . $value );
          }

        }
    }
    
    return $result;
    
  } // end of 'create' function
  
  private function createArray( $path, $hash = false ) {
    
    if( is_dir( $path ) === false ) {
      return null;
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
        if( is_dir( $path . $value ) ) { // is folder/dir
          
          $this->numberOfFolders += 1;
          
          if( $hash ) {
            $result[$key] = array( // open new dir
              $value => $this->createArray( $path . $value, $algo )
            );
          } else {
            $result[$key] = array( // open new dir
              $value => $this->createArray( $path . $value )
            );
          }
          
        } else { // is file
          
          $this->numberOfFiles += 1;
          
          if( $hash ) { // if hash set, generate hash from file
            $result[$key] = $this->fileInfo( $path . $value, $algo );
          } else {
            $result[$key] = $this->fileInfo( $path . $value );
          }

        }
    }

    return $result;

  } // end of 'createArray' function
  
  
  /* 'fileInfo' function create array about file
      return array:
        0. file name
        1. permission (0 = fail)
        2. 
  */
  private function fileInfo( $path, $hash = false ) {
    
    $fileName = basename( $path );
    $filePermission = substr ( sprintf( '%o', fileperms( $path ) ), -4 );
    $fileDev = $filMode = $filNlink = $fileRdev = $fileSize = $fileAtime = $fileMtime = $fileCtime = 0;
    
    $stat = stat( $path );
    
    
    if( $stat !== false ) {
      $fileDev = $stat['dev'];
      $filMode = $stat['mode'];
      $filNlink = $stat['nlink'];
      $fileRdev = $stat['rdev'];
      $fileSize = $stat['size'];
      $fileAtime = $stat['atime'];
      $fileMtime = $stat['mtime'];
      $fileCtime = $stat['ctime'];
    }
    
    if( $hash !== false ) {
      
      $hash = hash_file( $hash, $path );
      if( $hash === null || $hash === false ) {
        $hash = 'fail';
      } else {
        $this->numberOfHash += 1;
      }
      
    }
    
    $result = array(
      $fileName,
      $filePermission,
      $fileDev,
      $filMode,
      $filNlink,
      $fileRdev,
      $fileSize,
      $fileAtime,
      $fileMtime,
      $fileCtime,
      $hash
    );
    
    return $result;
  } // enf of 'fileInfo' private function
  
  
  
} // end of 'FileTree' class

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
