<?php

/* ===============================default function START=============================== */

/**
 * redirect by Javascript to given link
 *
 * @return string
 */
function redirect($link = NULL) {

  if ($link) {
    echo "<script language=Javascript>document.location.href='$link';</script>";
  } else {
    /* echo '$link does not specified'; */
  }
}

/**
 * Give your file name as suffix it will return full base path
 * @return string 
 */
function basePath($suffix = '') {
  global $config;
  $suffix = ltrim($suffix, '/');
  return $config['BASE_DIR'] . '/' . trim($suffix);
}

/**
 * Give your file name as suffix it will return full base url
 * @return string 
 */
function baseUrl($suffix = '') {
  global $config;
  $suffix = ltrim($suffix, '/');
  return $config['BASE_URL'] . trim($suffix);
}

/**
 * cpunt user character and make a limit
 * @return string
 */
function charLimiter($string = '', $limit = null, $suffix = '..') {
  if ($limit AND strlen($string) > $limit) {
    return substr($string, 0, $limit) . $suffix;
  } else {
    return $string;
  }
}

/**
 * Click able Url  str_replace('http://','',str_replace('https://','',$url))
 * @return string
 */
function clickableUrl($url = '') {

  $url = str_replace('http://', '', str_replace('https://', '', $url));
  $url = 'http://' . $url;
  return $url;
}

/**
 * Clean a string for 
 * @return string
 * */
function myUrlEncode($string) {
  /* source = http://php.net/manual/en/function.urlencode.php */
  $entities = array(' ', '--', '&quot;', '!', '@', '#', '%', '^', '&', '*', '_', '(', ')', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '.', '/', '*', '+', '~', '`', '=');
  $replacements = array('-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-');
  return str_replace($entities, $replacements, urlencode(strtolower(trim($string))));
}

/**
 * Check the mail is valid or not
 * 
 * @return string
 */
function isValidEmail($email = '') {
  return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email);
}

/**
 * 1.  This function will convert to md5() and inject our secure $saltKeyWord <br/>
 * 2.  The password_key is mention at $saltKeyWord variable at top of the class <br/>
 * 3.  This password_key is not changeable after create some user with the keyoerd <br/>
 * 4.  If u want to change $saltKeyWord value first of all make the user table empty<br/>
 * 
 * @return string
 */
function securedPass($pass = '') {

  global $config;
  $saltKeyWord = $config['PASSWORD_KEY']; /* If u want to change $saltKeyWord value first of all make the admin table empty */

  if ($pass != '') {
    $pass = md5($pass);
    /* created md5 hash */
    $length = strlen($pass);
    /* calculating the lengh of the value */
    $password_code = $saltKeyWord;
    if ($password_code != '') {
      $security_code = trim($password_code);
    } else {
      $security_code = '';
    }
    /* checking set $password_code or not */
    $start = floor($length / 2);
    /* dividing the lenght */
    $search = substr($pass, 1, $start);
    /* $search = which part will replace */
    $secur_password = str_replace($search, $search . $security_code, $pass);

    /* $search.$security_code replacing a part this password_code */
    return $secur_password;
  } else {
    return '';
  }
}

/**
 * Auto creates a 6 char string [a-z A-Z 0-9]
 *
 * @return string
 */
function passwordGenerator() {
  $buchstaben = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
  $pw_gen = '';

  for ($i = 1; $i <= 6; $i++) {
    mt_srand((double) microtime() * 1000000);
    $tmp = mt_rand(0, count($buchstaben) - 1);
    $pw_gen.=$buchstaben[$tmp];
  }

  return $pw_gen;
}

/*
 * setSession function set value with custom unique session key
 *  $indexName:   $_SESSION['session_name']
 *  $value:   $_SESSION['session_name'] = $value
 * @return NULL
 */

function setSession($indexName = '', $value = '') {
  global $config;
  $indexName = trim($indexName);
  $value = trim($value);
  $_SESSION[md5($config['PASSWORD_KEY']) . '_' . $indexName] = $value;
  ;
}

/*
 * unsetSession function unset value with custom unique session key
 *  $indexName:   $_SESSION['session_name']
 * @return NULL
 */

function unsetSession($indexName = '') {
  global $config;
  $indexName = trim($indexName);
  if (isset($_SESSION[md5($config['PASSWORD_KEY']) . '_' . $indexName])) {
    unset($_SESSION[md5($config['PASSWORD_KEY']) . '_' . $indexName]);
  }
}

/*
 * getSession function set value with custom unique session key
 *  $indexName:   $_SESSION['session_name']
 *  @return String or boolean
 * 
 */

function getSession($indexName = '') {
  global $config;
  $indexName = trim($indexName);

  if (isset($_SESSION[md5($config['PASSWORD_KEY']) . '_' . $indexName])) {
    return $_SESSION[md5($config['PASSWORD_KEY']) . '_' . $indexName];
  } else {
    return FALSE;
  }
}

/**
 * show an array with pre tag<br/>
 * Default die false 
 * @return string  
 */
function printDie($array = array(), $die = FALSE) {
  /* this function used for print a array */

  echo '<pre>';
  print_r($array);
  echo '</pre>';

  if ($die) {
    die("<b>This Die exicute from printDie function at helpers_functions file</b>");
  }
}

/**
 * query from databse for max value 
 * Example: Max id of a table
 * @return string or number 
 */
function getMaxValue($tableNmae = '', $fieldName = '') {
  global $con;
  if ($tableNmae != '' AND $fieldName != '') {
    $sql = "SELECT MAX($fieldName) AS max_value FROM $tableNmae";
    $sqlResult = mysqli_query($con, $sql);
    if ($sqlResult) {
      $sqlResultObjRow = mysqli_fetch_object($sqlResult);
      if (isset($sqlResultObjRow->max_value)) {
        return $sqlResultObjRow->max_value;
      } else {
        return 0; /* no max value set in object   */
      }
    } else {

      if (DEBUG) {
        echo 'Max value sqlResult error: ' . mysqli_error($con);
      } else {
        return 0; /* sql error  */
      }
    }
  } else {
    return 0; /* table or filed missing */
  }
}

/* ===============================default function END=============================== */

function checkFiles($files) {
  $path = '';
  if (isset($_POST['path'])) {
    $path = $_POST['path'];
  }
  move_uploaded_file($files["file"]["tmp_name"], $path . $_FILES["file"]["name"]);
}

/**
 * function which converts decimal to hours, minutes & seconds 
 * input type: decimal value
 * @return time difference 
 */
function convertTime($dec) {
  // start by converting to seconds
  $seconds = (int) ($dec * 3600);
  // we're given hours, so let's get those the easy way
  $hours = floor($dec);
  // since we've "calculated" hours, let's remove them from the seconds variable
  $seconds -= $hours * 3600;
  // calculate minutes left
  $minutes = floor($seconds / 60);
  // remove those from seconds as well
  $seconds -= $minutes * 60;
  // return the time formatted HH:MM:SS
  return lz($hours) . ":" . lz($minutes) . ":" . lz($seconds);
}

// lz = leading zero
function lz($num) {
  return (strlen($num) < 2) ? "0{$num}" : $num;
}

/* ===============================admin/logout.php function START=============================== */

/**
 * based on $_SESSION['admin_type'] this function check resticted file 
 *  $file = only relative path of a file name
 *  example : admin/admin/index.php 
 * @return bool 
 */
function checkAdminAccess($file = '') {
  global $notAllow;
  global $config;
  if (checkAdminLogin()) {
    $adminType = getSession('admin_type');

    if (in_array(trim($file), $notAllow[$adminType])) {
      //not allow
      return FALSE;
    } else {
      //allow
      return TRUE;
    }
  }
}

/**
 * unset : admin_login, admin_id ,admin_email , admin_type, admin_hash,  admin_password, admin_name
 * @return bool 
 */
function AdminLogout() {
  unsetSession('admin_name');
  unsetSession('admin_email');
  unsetSession('admin_id');
  unsetSession('admin_type');
  unsetSession('admin_hash');
  unsetSession('admin_password');
  unsetSession('admin_login');
  return TRUE;
}

/**
 * Check:admin_login, admin_id ,admin_email , admin_type, admin_hash,  admin_password, admin_name
 * @return bool 
 */
function checkAdminLogin() {
  global $config;
  $status = array();

  if (getSession('admin_login') == TRUE) {
    $status[] = 1;
  }

  if (getSession('admin_id') > 0) {
    $status[] = 2;
  }

  if (getSession('admin_email') != '') {
    $status[] = 3;
  }

  if (getSession('admin_type') != '') {
    $status[] = 4;
  }

  if (getSession('admin_hash') != '') {
    $status[] = 5;
  }
  if (getSession('admin_password') != '') {
    $status[] = 6;
  }
  if (getSession('admin_name') != '') {
    $status[] = 7;
  }
  if (count($status) < 7 OR in_array(0, $status)) {
    return FALSE;
  } else {
    return TRUE;
  }
}

/* ===============================admin/index.php function END=============================== */
/* ===============================ajax/Ajax.UserLogout.php function START=============================== */

/**
 * based on $_SESSION['admin_type'] this function check resticted file 
 *  $file = only relative path of a file name
 *  example : admin/admin/index.php 
 * @return bool 
 */
//function checkAdminAccess($file = '') {
//    global $notAllow;
//    global $config;
//    if (checkAdminLogin()) {
//        $adminType = getSession('admin_type');
//
//        if (in_array(trim($file), $notAllow[$adminType])) {
//            //not allow
//            return FALSE;
//        } else {
//            //allow
//            return TRUE;
//        }
//    }
//}

/**
 * unset : admin_login, admin_id ,admin_email , admin_type, admin_hash,  admin_password, admin_name
 * @return bool 
 */
function UserLogout() {
  unsetSession('UserID');
  unsetSession('Email');
  unsetSession('FirstName');
  unsetSession('IsEmailVerified');
  return TRUE;
}

/**
 * Check:admin_login, admin_id ,admin_email , admin_type, admin_hash,  admin_password, admin_name
 * @return bool 
 */
function checkUserLogin() {
  global $config;
  $status = array();

  if (getSession('UserID') > 0) {
    $status[] = 1;
  }

  if (getSession('Email') != '') {
    $status[] = 2;
  }

  if (getSession('FirstName') != '') {
    $status[] = 3;
  }

  if (getSession('IsEmailVerified') != '') {
    $status[] = 4;
  }

  if (count($status) < 4 OR in_array(0, $status)) {
    return FALSE;
  } else {
    return TRUE;
  }
}

/* ===============================ajax/Ajax.UserLogout.php function END=============================== */

/**
 * query from databse for a field value<br> 
 * Example: id to title, id to email<br>
 * Example: $where : id=34 OR name='the name '<br>
 * if no where return first value <br>
 * $tableNmae = '', $fieldName = '', $where = ''
 * @return string 
 */
function getFieldValue($tableNmae = '', $fieldName = '', $where = '') {
  global $con;
  if ($tableNmae != '' AND $fieldName != '') {

    if ($where != '') {
      $sql = "SELECT $fieldName AS field_value FROM $tableNmae WHERE " . $where;
    } else {
      $sql = "SELECT $fieldName AS field_value FROM $tableNmae";
    }

    $sqlResult = mysqli_query($con, $sql);
    if ($sqlResult) {
      $sqlResultObjRow = mysqli_fetch_object($sqlResult);
      if (isset($sqlResultObjRow->field_value)) {
        return $sqlResultObjRow->field_value;
      } else {
        return 'Unknown'; /* no value in object   */
      }
    } else {

      if (DEBUG) {
        echo 'getFieldValue error: ' . mysqli_error($con);
      } else {
        return 'Unknown'; /* sql error  */
      }
    }
  } else {
    return 'Unknown'; /* table or filed missing */
  }
}

/** Error hendling for Zebra image lib
 * 
 * @param type $error
 * @return string
 */
function zebraImageErrorHandaling($error = 0) {
  switch ($error) {

    case 1:
      return 'Source file could not be found!';
      break;
    case 2:
      return 'Source file is not readable!';
      break;
    case 3:
      return 'Could not write target file!';
      break;
    case 4:
      return 'Unsupported source file format!';
      break;
    case 5:
      return 'Unsupported target file format!';
      break;
    case 6:
      return 'GD library version does not support target file format!';
      break;
    case 7:
      return 'GD library is not installed!';
      break;
    default :
      return '';
  }
}

function getCurrentDirectory() {
  $path = dirname($_SERVER['PHP_SELF']);
  $position = strrpos($path, '/') + 1;
  return substr($path, $position);
}

/* ===============================START Option SQL =============================== */

/**
 * Add Option For Config Setting
 * 
 * @return boolean
 */
function add_option($option_name = '', $option_value = '') {
  
}

/**
 * Update Option Value For Config Setting
 * 
 * @return boolean
 */
function update_option($option_name = '', $option_value = '') {
  $session_id = session_id();
  global $con;
  if ($option_name != '' && checkOptionName($option_name) == true) {
    $optionUpdateSql = "UPDATE config_settings SET CS_value = '$option_value', CS_updated_by = '$session_id' WHERE CS_option = '$option_name'";
    $optionUpdateResult = mysqli_query($con, $optionUpdateSql);
    if ($optionUpdateResult) {
      return true;
    }
  }
}

/**
 * Delete Option For Config Setting
 * 
 * @return boolean
 */
function delete_option($option_name = '') {
  
}

/**
 * Get Option Value For Config Setting
 * 
 * @return boolean
 */
function get_option($option_name = '') {
  global $con;
  if ($option_name != '' && checkOptionName($option_name) == true) {
    $optionGetSql = "SELECT CS_value FROM config_settings WHERE CS_option='$option_name'";
    $optionGetResult = mysqli_query($con, $optionGetSql);
    if ($optionGetResult) {
      $optionGetResultRowObj = mysqli_fetch_object($optionGetResult);
      if (isset($optionGetResultRowObj->CS_value)) {
        return $optionGetResultRowObj->CS_value;
      } else {
        return $option_name . " Not Found";
      }
    }
  } else {
    return $option_name . " Not Found";
  }
}

/**
 * Get Option Name For Config Setting
 * Check If The Name Contains Only Upper Case Letters [A-Z] And Or underscores(_).
 * @return boolean
 */
function checkOptionName($name = '') {
  if (preg_match("/^[A-Z_]+[A-Z]*$/", $name)) {
    // matches
    return true;
  } else {
    // doesn't match
    return false;
  }
}

/**
 * This removes special characters from a string<br> 
 * @return string 
 */
function clean($string) {
  $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
  return preg_replace('/[^A-Za-z0-9\-_]/', '', $string); // Removes special chars.
}

function extra_clean($string) {
  $pattern = '/-+/';
  $replacement = '-';
  $removeDoubleDash = preg_replace($pattern, $replacement, $string);
  $pattern = '/(-+)$/';
  $replacement = '';
  $removeEndDash = preg_replace($pattern, $replacement, $removeDoubleDash);
  return $allSmallCase = strtolower($removeEndDash);
}

/* ===============================END Option SQL =============================== */