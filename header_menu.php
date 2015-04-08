<?php
//include './config/config.php';
$mainCategoryIds = '';
$mainProductCategoryArray = array();
$mainProductCategoryArrayCounter = 0;
$productSubCategoryArray = array();
$productSubCategoryCounter = 0;
$product_category_id = $config['PRODUCT_CATEGORY_ID'];

/* main category query */

$productCategorySql = "SELECT 
                        categories.category_id,categories.category_name,categories.category_parent_id,categories.category_logo,
                        category_promotion.CP_title,category_promotion.CP_image_name
                        
                        FROM categories 
                        
                        LEFT JOIN category_promotion ON category_promotion.CP_category_id=categories.category_id 
                        WHERE categories.category_parent_id=$product_category_id 
                        ORDER BY categories.category_priority DESC LIMIT 5";
$productCategorySqlResult = mysqli_query($con, $productCategorySql);
if ($productCategorySqlResult) {
  $mainProductCategoryArrayCounter = mysqli_num_rows($productCategorySqlResult);
  while ($productCategorySqlResultRowObj = mysqli_fetch_object($productCategorySqlResult)) {
    $mainProductCategoryArray[] = $productCategorySqlResultRowObj;
    $mainCategoryIds .= $productCategorySqlResultRowObj->category_id . ', ';
  }
  mysqli_free_result($productCategorySqlResult);
} else {
  if (DEBUG) {
    die('productCategorySqlResult error : ' . mysqli_error($con));
  } else {
    die('productCategorySqlResult query fail');
  }
}
$mainCategoryIds = trim($mainCategoryIds, ', ');

/* //main category query */



/* sub category query */
if ($mainCategoryIds != '') {
  $productSubCategorySql = "SELECT * FROM categories WHERE category_parent_id IN($mainCategoryIds)  ORDER BY category_name ASC";
  $productSubCategorySqlResult = mysqli_query($con, $productSubCategorySql);
  if ($productSubCategorySqlResult) {
    $productSubCategoryCounter = mysqli_num_rows($productSubCategorySqlResult);
    while ($productSubCategorySqlResultResultRowObj = mysqli_fetch_object($productSubCategorySqlResult)) {
      $cat_id = $productSubCategorySqlResultResultRowObj->category_parent_id;
      $productSubCategoryArray[$cat_id][] = $productSubCategorySqlResultResultRowObj;
    }
    mysqli_free_result($productSubCategorySqlResult);
  } else {
    if (DEBUG) {
      die('productSubCategorySqlResult error : ' . mysqli_error($con));
    } else {
      die('productSubCategorySqlResult query fail');
    }
  }
}

/* //sub category query */


//printDie($productSubCategoryArray);
?>
<?php if ($mainProductCategoryArrayCounter > 0): ?>
  <div class="menuBar">
    <div class="container">

 <div class="row">

      <div class="navbar-header ">
        <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>

      


      <div class="navbar-collapse collapse ">
        
        
        <div class="hidden-lg hidden-md hidden-sm" >
        <!-- Classic list -->
        <div class="form-horizontal">
          <div class="searchBar  searchBarMini col-xs-12">
            <form action="<?php echo baseUrl(); ?>search.php" method="get">
              <input name="search_by" type="text" class="col-xs-8 searchField" id="appendedInputButton">

           
              <button class="btn searchBtn col-xs-4" type="submit"> <i class="fa fa-search"> </i></button>
            </form>
            
          </div>

        </div>
  <div style="clear:both"></div>
        <div style="clear:both"></div>
        <?php if (getSession('UserName') != '' AND getSession('Email') != ''): ?>
          <div class="col-xs-6 pull-left" id="loginDiv"> <a href="javascript:void(0)" class=" btn-bj btn-log btn-block"><?php echo getSession('UserName'); ?></a> </div>
          <div class="col-xs-6 pull-right" id="signupDiv"> <a href="javascript:void(0)" class=" btn-bj btn-signup btn-block" onClick="userLogout();"> Logout </a> </div>
        <?php else: ?>
          <div class="col-xs-6 pull-left" id="loginDiv"> <a class=" btn-bj btn-log btn-block" data-toggle="modal" data-target="#ModalLogin" id="signinPopup"> Login </a> </div>
          <div class="col-xs-6 pull-right" id="signupDiv"> <a class=" btn-bj btn-signup btn-block" data-toggle="modal" data-target="#ModalSignup"> Sign Up </a> </div>
        <?php endif; ?>

      </div>

      <div style="clear:both"></div>
          <div style="clear:both"></div>
        
        <ul class="nav navbar-nav w100">

          <?php for ($i = 0; $i < $mainProductCategoryArrayCounter; $i++): ?>
            <?php
            $menu_cat_id = $mainProductCategoryArray[$i]->category_id;
            $menu_cat_name = $mainProductCategoryArray[$i]->category_name;
            $menu_cat_pro_image = $mainProductCategoryArray[$i]->CP_image_name;
            $menu_cat_pro_title = $mainProductCategoryArray[$i]->CP_title;
            ?>
            <li class="dropdown megamenu-80width "> <a title="<?php echo $menu_cat_name; ?> " class="dropdown-toggle" href="<?php echo baseUrl(); ?>category/<?php echo $menu_cat_id; ?>/<?php echo extra_clean(clean($menu_cat_name)); ?>"> <?php echo $menu_cat_name; ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li> 
                  <!-- Content container to add padding -->
                  <div class="megamenu-content">
                    <?php if($menu_cat_pro_image != '' AND file_exists(basePath('upload/category_promotion/' . $menu_cat_pro_image))): ?>
                    <ul class="col-lg-6 col-md-6 col-sm-6 hidden-xs noMarginLeft">
                      <p> <img alt="<?php echo $menu_cat_pro_title; ?>" src="<?php echo baseUrl(); ?>upload/category_promotion/<?php echo $menu_cat_pro_image; ?>"> </p>
                    </ul>
                    <?php  endif; ?>

                    <!--<ul class="col-lg-6 col-md-6 col-sm-6 col-xm-12 unstyled  hidden-xs">
                      <li>
                        <p><strong><?php //echo $menu_cat_name; ?></strong></p>
                      </li>

                    </ul>-->

                    <?php if (isset($productSubCategoryArray[$menu_cat_id]) AND count($productSubCategoryArray[$menu_cat_id]) > 0): ?>
                      <?php
                      $sub_cat_total = count($productSubCategoryArray[$menu_cat_id]);
                      $sub_cat_per_colm = ceil($sub_cat_total / 2);
                      ?>
                      <ul class="col-lg-3 col-md-3 col-sm-3 unstyled">
                        <?php for ($j = 0; $j < $sub_cat_total; $j++): ?>
                          <?php
                          $sub_cat_id = $productSubCategoryArray[$menu_cat_id][$j]->category_id;
                          $sub_cat_name = $productSubCategoryArray[$menu_cat_id][$j]->category_name;
                          ?>
                          <?php if ($j != 0 AND ($j % $sub_cat_per_colm == 0)): ?>
                          </ul> <ul class="col-lg-3 col-md-3 col-sm-3 unstyled">
                          <?php endif; /* ($j%$sub_cat_per_colm==0) */ ?>


                            <li> <a title="<?php echo $sub_cat_name; ?>" href="<?php echo baseUrl() . 'category/' . $sub_cat_id . '/' . extra_clean(clean($sub_cat_name)); ?>"><?php echo $sub_cat_name; ?></a> </li>

                        <?php endfor; /* ($j; $j < $sub_cat_total ;$j++) */ ?>
                      </ul>
                    <?php endif; /* (isset($productSubCategoryArray[$menu_cat_id]) AND count($productSubCategoryArray[$menu_cat_id]) > 0) */ ?>




                  </div>
                </li>
              </ul>
            </li>
          <?php endfor; /* ($i=0; $i < $mainProductCategoryArrayCounter; $i++) */ ?>

        </ul>
      </div>
      <div style="clear:both"></div>
    </div>
    </div>
    <!--/.nav-collapse --> 
  </div>
<?php endif; /* ($mainProductCategoryArrayCounter > 0) */ ?>
