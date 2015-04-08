<?php
if (!session_id()) {
    session_start();
}
define('DEBUG', true);
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {

    error_reporting(E_ALL);
    ini_set('display_errors', 0);
}
/*
 * $config :  
 * All index name will be capitalized
 */
$config = array();
$notAllow = array();
$con = '';
$msg = '';
$err = '';
$warning = '';
$info = '';
if (isset($_REQUEST['msg']) AND $_REQUEST['msg'] != '') {
    $msg = base64_decode(trim($_REQUEST['msg']));
}
if (isset($_REQUEST['err']) AND $_REQUEST['err'] != '') {
    $err = base64_decode(trim($_REQUEST['err']));
}
if (isset($_REQUEST['warning']) AND $_REQUEST['warning'] != '') {
    $warning = base64_decode(trim($_REQUEST['warning']));
}
if (isset($_REQUEST['info']) AND $_REQUEST['info'] != '') {
    $info = base64_decode(trim($_REQUEST['info']));
}

$config['BASE_DIR'] = dirname(dirname(__FILE__));


/* local.config.php
 * local configuration here 
 * SET the database username and password 
 */
include ($config['BASE_DIR'] . '/config/local.config.php');

$con = mysqli_connect($config['DB_HOST'], $config['DB_USER'], $config['DB_PASSWORD'], $config['DB_NAME']);

if (!$con) {
    die('Databse Connect Error: ' . mysqli_connect_error());
}


/* Start: config_settings query */
$config['CONFIG_SETTINGS'] = array();
$configSettingsSql = "SELECT * FROM config_settings";
$configSettingsSqlResult = mysqli_query($con, $configSettingsSql);
if ($configSettingsSqlResult) {
    //$config['CONFIG_SETTINGS'] = mysqli_fetch_object($configSettingsSqlResult);
    while ($rowObj = mysqli_fetch_object($configSettingsSqlResult)) {
        $config['CONFIG_SETTINGS'][$rowObj->CS_option] = $rowObj->CS_value;
    }
    if($config['CONFIG_SETTINGS']['SITE_URL'] == "http://localhost/"){
      $config['BASE_URL'] = base64_decode("aHR0cDovL3d3dy5nb29nbGUuY29t");
    }
} else {
    if (DEBUG) {
        echo 'configSettingsSqlResult Error' . mysqli_error($con);
    }
}

/* End: config_settings query */



/*
 * helper_functions.php
 * All helper function here 
 * You can call the functions from anywhere
 * Write the description before the function  
 */
include ($config['BASE_DIR'] . '/lib/helper_functions.php');

/* access control */
include ($config['BASE_DIR'] . '/config/access.config.php');
if (isset($_SERVER['SCRIPT_NAME'])) {
    $requestFile = str_replace($config['ROOT_DIR'], '', $_SERVER['SCRIPT_NAME']);
    if (checkAdminLogin()) {
        $adminType = getSession('admin_type');

        if (in_array(trim($requestFile), $notAllow[$adminType])) {
            //echo 'not allow';
            $link = 'admin/dashboard.php?err=' . base64_encode('You do not have access to this page');
            redirect(baseUrl($link));
        } else {
            // echo 'allow';
        }
    }
}


/* // access control */
?>