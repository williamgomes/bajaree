<?php
include 'config/config.php';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

$pageTitle = '';
$pageBody = '';
$pageMetaTitle = '';
$pageMetaDesc = '';
$pageMetaKey = '';

$sqlGetPage = "SELECT * FROM pages WHERE page_id=4";
$resultGetPage = mysqli_query($con, $sqlGetPage);
if($resultGetPage){
  $resultGetPageObj = mysqli_fetch_object($resultGetPage);
  if(isset($resultGetPageObj->page_id)){
    $pageTitle = $resultGetPageObj->page_title;
    $pageBody = $resultGetPageObj->page_body;
    $pageMetaTitle = $resultGetPageObj->page_meta_title;
    $pageMetaDesc = $resultGetPageObj->page_meta_description;
    $pageMetaKey = $resultGetPageObj->page_meta_keywords;
  }
} else {
  if(DEBUG){
    $err = "resultGetPage error: " . mysqli_error($con);
  } else {
    $err = "There were some technical failure. We will be back soon.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $page_title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description; ?>">
    <meta name="keywords" content="<?php echo $page_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">

    <?php include basePath('header_script.php'); ?>
    <script src="<?php echo baseUrl(); ?>ajax/index/main.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>

<body>
<div id="wrapper">

  
  <div id="header">
        <div class="navbar navbar-default navbar-fixed-top megamenu">
          <div class="container-full">
            <?php include basePath('headertop.php'); ?>
            <!--/.headertop -->
            <?php include basePath('header_mid.php'); ?>
            <!--/.headerBar -->

            <?php include basePath('header_menu.php'); ?>
            <!--/.menubar --> 
          </div>
        </div>

      </div>
      <!-- header end -->
  
  <div class="w100 mainContainer">
  
  
  
  
       <div class="container">
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column">
       <div class="termsContent"> 
  <h1><?php echo $pageTitle; ?></h1>
  		
        <p><?php echo $pageBody; ?></p>
  </div>
    
    	</div>
        
  
       </div>
    
    
    
    <!--brandFeatured-->
    
 </div>
  <!-- Main hero unit -->
  
  <?php include basePath('footer.php'); ?>
  
</div>
<!-- /container --> 

    <?php include basePath('mini_login.php'); ?>
    <?php include basePath('mini_signup.php'); ?>
    <?php include basePath('mini_cart.php'); ?>

    <?php include basePath('footer_script.php'); ?>
    
    
  </body>
</html>
