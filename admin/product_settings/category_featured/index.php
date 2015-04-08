<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

//saving tags in database
$categories = array();
$aid = getSession('admin_id'); //getting admin id
$start_date = "";
$end_date = "";
$categories = "";
$CategoryID = 0;



if (isset($_POST['submit'])) {
  
  extract($_POST);
  if(isset($categories[0])){
    $CategoryID = $categories[0];
  }

  if($CategoryID == 0){
    $err = "Category is required.";
  } elseif($start_date == ''){
    $err = "Start date is required.";
  } elseif($end_date == ''){
    $err = "End date is required.";
  } else {
    
    //changing the format of date
    $startDate = date("Y-m-d",  strtotime($start_date));
    $endDate = date("Y-m-d",  strtotime($end_date));
    //checking if category already exist in database
    $countCategory = 0;
    $sqlCheckCategory = "SELECT * FROM category_featured WHERE CF_category_id=$CategoryID";
    $executeCheckCategory = mysqli_query($con,$sqlCheckCategory);
    if($executeCheckCategory){
      $countCategory = mysqli_num_rows($executeCheckCategory);
      if($countCategory > 0){ //category entry found in table
        //need to update category info in the table
        
        $updateFeatCategory = "";
        $updateFeatCategory .= ' CF_featured_from = "' . mysqli_real_escape_string($con, $startDate) . '"';
        $updateFeatCategory .= ', CF_featured_to = "' . mysqli_real_escape_string($con, $endDate) . '"';
        $updateFeatCategory .= ', CF_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

        $sqlUpdateCategory = "UPDATE category_featured SET $updateFeatCategory WHERE CF_category_id=$CategoryID";
        $executeUpdateCategory = mysqli_query($con,$sqlUpdateCategory);
        if($executeUpdateCategory){
          $msg = "Featured Category information updated successfully";
        } else {
          $err = "Update query failed";
          if(DEBUG){
            echo "$executeUpdateCategory error: " . mysqli_error($con);
          }
        }
      } else { //category didn't find in database
        //need to insert new entry for the category
        $addFeatCategory = "";
        $addFeatCategory .= ' CF_category_id = "' . mysqli_real_escape_string($con, $CategoryID) . '"';
        $addFeatCategory .= ', CF_featured_from = "' . mysqli_real_escape_string($con, $startDate) . '"';
        $addFeatCategory .= ', CF_featured_to = "' . mysqli_real_escape_string($con, $endDate) . '"';
        $addFeatCategory .= ', CF_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

        $sqlAddCategory = "INSERT INTO category_featured SET $addFeatCategory";
        $executeAddCategory = mysqli_query($con,$sqlAddCategory);
        if($executeAddCategory){
          $msg = "Featured Category information added successfully";
        } else {
          $err = "Insert query failed";
          if(DEBUG){
            echo "$executeAddCategory error: " . mysqli_error($con);
          }
        }
      }
    } else {
      $err = "Check query failed";
      if(DEBUG){
        echo "$executeCheckCategory error: " . mysqli_error($con);
      }
    }
  }
}


$arrayFeatCategory = array();
$sqlFeatCategory = "SELECT * FROM category_featured";
$executeFeatCategory = mysqli_query($con,$sqlFeatCategory);
if($executeFeatCategory){
  while($executeFeatCategoryObj = mysqli_fetch_object($executeFeatCategory)){
    $arrayFeatCategory[] = $executeFeatCategoryObj;
  }
} else {
  if(DEBUG){
    echo "$executeFeatCategory error: " . mysqli_error($con);
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Admin Panel | Category</title>

        <?php
include basePath('admin/header.php');
        ?>



        <!--Start: tree view--> 

        <link href="<?php echo baseUrl('admin/css/tree_style.css'); ?>" rel="stylesheet" type="text/css" />

        <script type="text/javascript">
            var leftSpace = 0;
            jQuery(document).ready(function($) {
                $('.tree li').each(function() {

                    if ($(this).children('ul').length > 0) {
                        $(this).addClass('parent');
                        leftSpace += 13;

                    }
                    if ($(this).find('input').is(':checked')) {
                        $(this).addClass(' active');
                        $(this).parent().css('display', 'block');
                        $('.treeParent').css('width', leftSpace + 700);

                    }


                });

                $('.treeParent').css('width', 700);
                $('.treeParent li').removeClass('active');
                $('.tree li.parent > a').click(function() {
                    $('.treeParent').css('width', leftSpace + 700);
                    $('.tree').css('overflow-x', 'scroll');
                    $(this).parent().toggleClass('active');
                    $(this).parent().children('ul').slideToggle('fast');
                });
            });
        </script>
        <!--End: tree view-->       


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
                <div class="title"><h5>Featured Category Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>


                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Featured Category</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="index.php" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Add Featured Category</h5></div>
                                        
                                        <div class="rowElem"><label>Select Category:</label><div class="formRight tree">

                                                <?php
                                                include basePath('lib/category2.php');
                                                $c = new Category2($con);
                                                ?> 

                                                <ul class="treeParent">
                                                    <li>
                                                        <a> </a>
                                                        <input type="radio" value="<?php echo $config['PRODUCT_CATEGORY_ID']; ?>" name="categories[]" />Root Category
                                                        <ul>
                                                            <?php
                                                            $c->inputType = 'radio';
//$c->checked = ;
                                                            echo $c->viewTree($config['PRODUCT_CATEGORY_ID']);
                                                            ?>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div><div class="fix"></div></div>

                                        <!--                                         End category div   -->
                                        
                                        <div class="rowElem noborder">
                                            <label>Start Date:</label>
                                            <div class="formRight">
                                                <input type="text"  name="start_date"  value="<?php echo $start_date; ?>" class="datepicker" />
                                            </div>
                                            <div class="fix"></div>
                                        </div>
                                        
                                        <div class="rowElem noborder">
                                            <label>End Date:</label>
                                            <div class="formRight">
                                                <input type="text"  name="end_date"  value="<?php echo $end_date; ?>" class="datepicker" />
                                            </div>
                                            <div class="fix"></div>
                                        </div>




                                        <input type="submit" name="submit" value="Add Featured Category" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>   
                                </fieldset>

                            </form>		

                        </div>





                        <div class="table">
                            <div class="head">
                                <h5 class="iFrames">Tags List</h5></div>
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Updated</th>
                                        <th>Updated By</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$countFeatCategory = count($arrayFeatCategory);
if($countFeatCategory > 0){
  for($i = 0; $i < $countFeatCategory; $i++){
    ?>
                                         <tr class="gradeA">
                                            <td><?php echo getFieldValue($tableNmae='categories', $fieldName='category_name', $where='category_id=' . $arrayFeatCategory[$i]->CF_category_id); ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($arrayFeatCategory[$i]->CF_featured_from)); ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($arrayFeatCategory[$i]->CF_featured_to)); ?></td>
                                            <td><?php echo $arrayFeatCategory[$i]->CF_updated; ?></td>
                                            <td><?php echo getFieldValue($tableNmae='admins', $fieldName='admin_full_name', $where='admin_id=' . $arrayFeatCategory[$i]->CF_updated_by); ?></td>
                                        </tr>
<?php                                  
  }
}
?>                        
</tbody>
                            </table>
                        </div>

                    </div>





                </div>
            </div>

        </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
