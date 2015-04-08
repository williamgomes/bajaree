<?php

/* change when upload to different domain 
 * setting site hosting  data 
 */

$host = $_SERVER['HTTP_HOST'];

$domain = str_replace('www.', '', str_replace('http://', '', $host));

if ($domain == 'testserver.bscheme.com') {
    $config['SITE_NAME'] = 'ecommerce';
    $config['BASE_URL'] = 'http://testserver.bscheme.com/bajaree/';
    $config['ROOT_DIR'] = '/home/bluetest/public_html/bajaree/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'bluetest_bajaree';
    $config['DB_USER'] = 'bluetest_ecom';
    $config['DB_PASSWORD'] = "!@#ecom!@#";
} else if ($domain == 'bajaree.com') {
    $config['SITE_NAME'] = 'Bluescheme ecommerce Plateform';
    $config['BASE_URL'] = 'http://bajaree.com/';
    $config['ROOT_DIR'] = '/var/www/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'bajaree';
    $config['DB_USER'] = 'root';
    $config['DB_PASSWORD'] = "buexheqbwsvh";
} else if ($domain == 'beta.bajaree.com') {
    $config['SITE_NAME'] = 'Bluescheme ecommerce Plateform';
    $config['BASE_URL'] = 'http://beta.bajaree.com/';
    $config['ROOT_DIR'] = '/var/www/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'bajaree';
    $config['DB_USER'] = 'root';
    $config['DB_PASSWORD'] = "buexheqbwsvh";
}else if ($domain == 'ori.bajaree.com') {
    $config['SITE_NAME'] = 'Bluescheme ecommerce Plateform';
    $config['BASE_URL'] = 'http://ori.bajaree.com/';
    $config['ROOT_DIR'] = '/var/www/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'original';
    $config['DB_USER'] = 'root';
    $config['DB_PASSWORD'] = "buexheqbwsvh";
} else {
    $config['SITE_NAME'] = 'ecommerce';
    $config['BASE_URL'] = 'http://localhost/bajaree/';
    $config['ROOT_DIR'] = '/bajaree/';
    $config['DB_TYPE'] = 'mysql';
    $config['DB_HOST'] = 'localhost';
    $config['DB_NAME'] = 'bajaree';
    $config['DB_USER'] = 'root';
    $config['DB_PASSWORD'] = '';
}

date_default_timezone_set('Asia/Dhaka');
$config['MASTER_ADMIN_EMAIL'] = "faruk@bscheme.com"; /* Developer */
$config['PASSWORD_KEY'] = "#b1a2j1r1e2*"; /* If u want to change PASSWORD_KEY value first of all make the admin table empty */
$config['ADMIN_PASSWORD_LENGTH_MAX'] = 15; /* Max password length for admin user  */
$config['ADMIN_PASSWORD_LENGTH_MIN'] = 5; /* Min password length for admin user  */
$config['ADMIN_COOKIE_EXPIRE_DURATION'] = (60 * 60 * 24 * 30); /* Min password length for admin user  */

$config['ITEMS_PER_PAGE'] = 20; /* Pagination */
$config['CATEGORY_ITEMS_PER_PAGE'] = 120; /*category.php */
$config['IMAGE_PATH'] = $config['BASE_DIR'] . '/images'; /* system image path */
$config['IMAGE_URL'] = $config['BASE_URL'] . 'images'; /* Upload system path */
$config['IMAGE_UPLOAD_PATH'] = $config['BASE_DIR'] . '/upload'; /* Upload files go here */
$config['IMAGE_UPLOAD_URL'] = $config['BASE_URL'] . 'upload'; /* Upload link with this */

$config['MAX_CATEGORY_LEVEL'] = 10; /* to control category level */
$config['PRODUCT_CATEGORY_ID'] = 2; /* product category id start from here */
$config['BOOKMARK_CATEGORY_ID'] = 119; /* bookmark category id start from here */
$config['BRAND_CATEGORY_ID'] = 1; /* Brand category id start from here */
$config['CATEGORY_CAROUSEL_LIMIT'] = 8; /* product category page per category slide limit */
$config['COUPON_MAX_APPLY'] = 4; /* Maximum attempt time for applying coupon code */
/*define banner areas*/
$config['BANNER_AREA']['HOME']="Home page top ";
$config['BANNER_AREA']['NEW']="New arrival page";
$config['BANNER_AREA']['SALES']="Sales page";

/*define banner areas*/

$config['CURRENCY'] = "TK"; /* ---Image Maximum height : This ratio will multiply with image width , if Image height exceed Image Maximum height then Image cann't upload */
$config['CURRENCY_SIGN'] = "৳"; /* ---Image Maximum height : This ratio will multiply with image width , if Image height exceed Image Maximum height then Image cann't upload */


/* Start of magic quote remover function
  This function is used for removing magic quote, Thats means using this function no slash will add automatically before quotations */
if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}

    /* End of magic quote remover function */
   
