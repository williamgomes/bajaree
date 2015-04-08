
<footer>
  <div class="footer">
    <div class="footer-banner">
      <div class="container text-center"><h1><img src="<?php echo baseUrl(); ?>images/bajaree-footerB.png" class="img-responsive" alt="banner"></h1>
      </div>
    </div>

    <div class="container footer-container">
      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
        <h3>About </h3>
        <ul>
	  <li><a href="<?php echo baseUrl(); ?>comingsoon.php">Team</a></li>
          <li><a href="<?php echo baseUrl(); ?>comingsoon.php">Blog </a></li>
          <li><a href="<?php echo baseUrl(); ?>contact-us">Contact Us</a></li>
	   <li><a href="<?php echo baseUrl(); ?>terms-of-use">Terms</a></li>

        </ul>

      </div>

      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
	<h3>Customer</h3>
        <ul>
          <li><a href="<?php echo baseUrl(); ?>how-it-works">How it Works</a></li>
          <li><a href="<?php echo baseUrl(); ?>faq">FAQ</a></li>
          <li><a href="<?php echo baseUrl(); ?>customer-support">Customer Support</a></li>
          <li><a href="<?php echo baseUrl(); ?>privacy-policy">Privacy </a></li>
        </ul>

      </div>
      <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
	<h3>Products</h3>
        <ul>
         
          <li><a href="<?php echo baseUrl(); ?>comingsoon.php">Become A Seller</a></li>
 		<li><a href="<?php echo baseUrl(); ?>comingsoon.php">Corporate Accounts</a></li>
		<li><a href="<?php echo baseUrl(); ?>comingsoon.php">Partners</a></li>
		<li><a href="<?php echo baseUrl(); ?>comingsoon.php">Suggest a Product</a></li>
        </ul>
      </div>

   <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 ">
	
      </div>


   <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 imgblog">
	<h3>Blog</h3>
    	<ul>
          <li><a href="<?php echo baseUrl(); ?>comingsoon.php"> 
 	<img src="<?php echo baseUrl(); ?>/images/blog1.png" alt="blog"></a></li>
	</ul>
      </div>

   <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4 imgblog">
	<h3>Payment</h3>
    	<ul>
          <li><a href="<?php echo baseUrl(); ?>comingsoon.php"><img src="<?php echo baseUrl(); ?>/images/blog2.png" alt="blog"></a></li>
	</ul>
      </div>

<div class="col-md-6 text-right pull-right hide" >

 <ul class="list-inline pull-left socialul ">
<li><a>Find us at these social space</a></li>

            <?php if (get_option('FACEBOOK_LINK') != ''): ?>
              <li><a href="<?php echo get_option('FACEBOOK_LINK'); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <?php else: ?>
              <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>

            <?php if (get_option('TWITTER_LINK') != ''): ?>
              <li><a href="<?php echo get_option('TWITTER_LINK'); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <?php else: ?>
              <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
            <?php endif; ?>

            <?php if (get_option('GOOGLE_PLUS_LINK') != ''): ?>
              <!--<li><a href="<?php echo get_option('GOOGLE_PLUS_LINK'); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>-->
            <?php else: ?>
              <!--<li><a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a></li>-->
            <?php endif; ?>

            <?php if (get_option('LINKEDIN_LINK') != ''): ?>
              <!--<li><a href="<?php echo get_option('LINKEDIN_LINK'); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>-->
            <?php else: ?>
              <!--<li><a href="javascript:void(0)"><i class="fa fa-linkedin"></i></a></li>-->
            <?php endif; ?>

            <?php if (get_option('PINTEREST_LINK') != ''): ?>
              <!--<li><a href="<?php echo get_option('PINTEREST_LINK'); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>-->
            <?php else: ?>
              <!--<li><a href="javascript:void(0)"><i class="fa fa-pinterest"></i></a></li>-->
                <?php endif; ?>
          </ul>


</div>
      <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 newsLatterSubscribe hide">
        <h4 class="supportT "><i class="fa fa-phone"></i> Support : </h4>
        <p style="padding-top: 10px;"></p>
        <p class="text-left"> <img src="<?php echo baseUrl(); ?>/images/payment-method.png" alt="">

      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container ">
      <div class="row">
        <div class="col-md-4 text-left">
          <p>Copyright &copy; 2014 Bluescheme Inc. All rights reserved.</p>

        </div>

        <div class="col-md-4 text-center">
          <p>Made with <i class="fa fa-heart"></i> in Dhaka.</p>

        </div>

        <div class="col-md-4 text-left">
          <ul class="list-inline pull-right socialul">

            <?php if (get_option('FACEBOOK_LINK') != ''): ?>
              <li><a href="<?php echo get_option('FACEBOOK_LINK'); ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <?php else: ?>
              <li><a href="javascript:void(0)"><i class="fa fa-facebook"></i></a></li>
            <?php endif; ?>

            <?php if (get_option('TWITTER_LINK') != ''): ?>
              <li><a href="<?php echo get_option('TWITTER_LINK'); ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <?php else: ?>
              <li><a href="javascript:void(0)"><i class="fa fa-twitter"></i></a></li>
            <?php endif; ?>

            <?php if (get_option('GOOGLE_PLUS_LINK') != ''): ?>
              <!--<li><a href="<?php echo get_option('GOOGLE_PLUS_LINK'); ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>-->
            <?php else: ?>
              <!--<li><a href="javascript:void(0)"><i class="fa fa-google-plus"></i></a></li>-->
            <?php endif; ?>

            <?php if (get_option('LINKEDIN_LINK') != ''): ?>
              <!--<li><a href="<?php echo get_option('LINKEDIN_LINK'); ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>-->
            <?php else: ?>
              <!--<li><a href="javascript:void(0)"><i class="fa fa-linkedin"></i></a></li>-->
            <?php endif; ?>

            <?php if (get_option('PINTEREST_LINK') != ''): ?>
              <!--<li><a href="<?php echo get_option('PINTEREST_LINK'); ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li>-->
            <?php else: ?>
              <!--<li><a href="javascript:void(0)"><i class="fa fa-pinterest"></i></a></li>-->
                <?php endif; ?>
          </ul>

        </div>







      </div>
    </div>
  </div>
</footer>