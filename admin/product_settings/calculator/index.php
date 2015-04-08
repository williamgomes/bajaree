<?php
include ('../../../config/config.php');
include '../../../lib/category2.php';
$cat2DD = new Category2($con); /* $cat2DD == category2 library dropdown */

if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$CategoryID = 0;
$TotalPrice = 0;
$TotalProduct = 0;

//get all level one category
$arrayCategory = array();
$sqlCategory = "SELECT * FROM categories WHERE category_parent_id=2";
$executeCategory = mysqli_query($con,$sqlCategory);
if($executeCategory){
  while($executeCategoryObj = mysqli_fetch_object($executeCategory)){
    $arrayCategory[] = $executeCategoryObj;
  }
} else {
  if(DEBUG){
    echo "executeCategory error: " . mysqli_error($con);
  } else {
    echo "executeCategory query failed.";
  }
}



if(isset($_GET['submit']) AND isset($_GET['category'])){
  $CategoryID = intval($_GET['category']);
//  $allCategories = '';
//  $getAllCategory = array();
//  $sqlGetCategories = "SELECT category_id 
//    
//                      FROM categories 
//                      
//                      WHERE category_id=$CategoryID OR category_parent_id IN 
//                      (SELECT category_id FROM categories WHERE (category_id=$CategoryID OR category_parent_id=$CategoryID))";
//  $executeGetCategories = mysqli_query($con,$sqlGetCategories);
//  if($executeGetCategories){
//    while($executeGetCategoriesObj = mysqli_fetch_object($executeGetCategories)){
//      $getAllCategory[] = $executeGetCategoriesObj->category_id;
//    }
//  } else {
//    if(DEBUG){
//      echo "executeGetCategories error: " . mysqli_error($con);
//    } else {
//      echo "executeGetCategories query failed.";
//    }
//  }
//  
//  
//  $allCategories = implode(',', $getAllCategory);
  
  $sqlGetCategoryInfo = "SELECT DISTINCT product_id, COUNT(PC_product_id) AS TotalProduct, SUM(PI_current_price) AS TotalPrice
                          
                         FROM product_categories
                         
                         LEFT JOIN product_inventories ON PI_product_id=PC_product_id
                         LEFT JOIN products ON product_id=PC_product_id
                         WHERE PC_category_id=$CategoryID
                         AND product_status='active'";
  $executeGetCategoryInfo = mysqli_query($con,$sqlGetCategoryInfo);
  if($executeGetCategoryInfo){
    $executeGetCategoryInfoObj = mysqli_fetch_object($executeGetCategoryInfo);
    if(isset($executeGetCategoryInfoObj->TotalProduct)){
      $TotalPrice = $executeGetCategoryInfoObj->TotalPrice;
      $TotalProduct = $executeGetCategoryInfoObj->TotalProduct;
    }
  }
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Admin Panel | Category-wise Calculator</title>
        <link rel="shortcut icon" href="<?php echo baseUrl(); ?>admin/images/favicon.ico" />


        <?php
        include basePath('admin/header.php');
        ?>



        <!--Start: tree view--> 

        <link href="<?php echo baseUrl('admin/css/tree_style.css'); ?>" rel="stylesheet" type="text/css" />

       
    </head>

    <body>


        <?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->

            <?php include basePath('admin/product_settings/product_settings_left_navigation.php'); ?>
            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Calculator Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>


                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Category-wise Calculator</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="index.php" method="get" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Category-wise Calculator</h5></div>
                                        
                                        <div class="rowElem noborder"><label>Select Category:</label>
                                          <div class="formRight">
                                            <select name="category">
                                              <option value="<?php echo $config['PRODUCT_CATEGORY_ID']; ?>">All Product</option>
                                              <?php echo $cat2DD->viewDropdown($config['PRODUCT_CATEGORY_ID']); ?>
                                            </select>
                                          </div>
                                          <div class="fix"></div>
                                        </div>
                                        
                                      <?php if(isset($_GET['submit']) AND isset($_GET['category'])){ ?>
                                        <div class="stats">
                                          <ul>
                                            <li>Category Name: <strong><?php echo getFieldValue('categories', 'category_name', 'category_id=' . $CategoryID); ?></strong></li>
                                            <li>Total Product: <strong><?php echo $TotalProduct; ?></strong></li>
                                            <li>Total Value: <strong><?php echo $config['CURRENCY_SIGN']; ?> <?php if($TotalPrice == ''){ echo '0.00'; }else{ echo $TotalPrice; } ?></strong></li>
                                          </ul>
                                          <div class="fix"></div>
                                        </div>

                                      <?php } ?>
                                        
                                        <div class="fix"></div>
                                        <div class="fix"></div>

                                        <input type="submit" name="submit" value="View Info" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                        
                                        <div class="fix"></div>

                                    </div>   
                                </fieldset>

                            </form>		

                        </div>






                    </div>





                </div>
            </div>

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
