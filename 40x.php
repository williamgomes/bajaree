<?php
include 'config/config.php';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $page_description; ?>">
        <meta name="keywords" content="<?php echo $page_keywords; ?>">
        <meta name="author" content="<?php echo $site_author; ?>">

        <?php include basePath('header_script.php'); ?>
        <script src="<?php echo baseUrl(); ?>ajax/index/main.js"></script>

        <script>
            $(document).ready(function() {

                for (var i = 0; i < <?php echo count($arrayFeatCategory); ?>; i++) {

                    $("#homeCarousel_" + i).tnmCarousel({
                        navigation: false,
                        lazyLoad: true,
                        addClassActive: true,
                        items: 6,
                        itemsTablet: [768, 3],
                        itemsTabletSmall: [580, 2]

                    });
                }
            });
        </script>


</head>
<style>
body{
	background:#f3f3f3;	}
.error{
		margin:12% 0 0 0;}

</style>
<body class="home">
    <div id="wrapper">
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

      
      <p align="center"><img class="error" src="<?php echo baseUrl(); ?>images/error-page.png" alt="error" /></p> 
      
    <?php include basePath('footer.php'); ?>
    </div>
    <!-- /wrapper --> 
    
      <?php include basePath('mini_login.php'); ?>
        <?php include basePath('mini_signup.php'); ?>
        <?php include basePath('mini_cart.php'); ?>

<?php include basePath('footer_script.php'); ?>
    
</body>
</html>
