<?php
include 'config/config.php';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

//getting all data from database
$arrayFAQ = array();
$sqlFaq = "SELECT * FROM faq ORDER BY faq_priority DESC";
$executeFaq = mysqli_query($con,$sqlFaq);
if($executeFaq){
  while($executeFaqObj = mysqli_fetch_object($executeFaq)){
    $arrayFAQ[] = $executeFaqObj;
  }
} else {
  if(DEBUG){
    echo "executeFaq error: " . mysqli_error($con);
  } else {
    echo "executeFaq query failed.";
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

      <div style="clear:both"></div>
  <div class="w100 mainContainer">
  
  
  
  
       <div class="container">
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column">
       <div class="termsContent faqContent"> 
  <h1>Frequently Asked Questions (FAQs)</h1>
  		
        
       <div class="panel-group" id="accordion">
<?php
$countFaqArray = count($arrayFAQ);
if($countFaqArray > 0):
  for($a = 0; $a < $countFaqArray; $a++):
    ?>

      <div class="panel panel-default panel-bajaree">
        <div class="panel-heading panel-heading-bajaree">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
              <span class="glyphicon glyphicon-question-sign"></span> Can I checkout as a guest?
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
          <div class="panel-body">
            <p>You may check out as a guest. Simply place items in your shopping cart and complete the order process. You will be prompted to provide an email address so we may provide you with an Order Confirmation email and Order Status Update emails.</p>
          </div>
        </div>
      </div>

    <?php
  endfor;
else:
?>
         <div class="panel panel-default panel-bajaree">
           <h4>Currently no content available. We will update soon.</h4>
           </div>


<?php
endif; 
?>
  
  
</div>
    
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
