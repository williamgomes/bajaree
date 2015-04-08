<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

$aid = getSession('admin_id'); //get admin id
//saving tags in database
$mtitle = '';
$key = '';
$mdesc = '';
$pid = base64_decode($_GET['pid']);
$current_price = '';
$default_title = '';
$default_image = '';


if (isset($_POST['update'])) {
    extract($_POST);
    $err = "";
    $msg = "";

    if ($mtitle == "") {
        $err = "Meta Title is required.";
    } elseif ($key == "") {
        $err = "Meta Keyword is required.";
    } elseif ($mdesc == "") {
        $err = "Meta Description is required.";
    } elseif (!preg_match("/([A-Za-z0-9]+)/", $mtitle)) {
        $err = "Meta Title can only be alphanumeric.";
    } elseif (!preg_match("/([A-Za-z0-9]+)/", $key)) {
        $err = "Meta Keyword can only be alphanumeric.";
    } else {

        $UpdateMeta = '';
        $UpdateMeta .= ' product_meta_title = "' . mysqli_real_escape_string($con, $mtitle) . '"';
        $UpdateMeta .= ', product_meta_keywords = "' . mysqli_real_escape_string($con, $key) . '"';
        $UpdateMeta .= ', product_meta_description = "' . mysqli_real_escape_string($con, $mdesc) . '"';
        $UpdateMeta .= ', product_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

        $UpdateMetaSQL = "UPDATE products SET $UpdateMeta WHERE product_id='$pid'";
        $ExecuteMetaSQL = mysqli_query($con, $UpdateMetaSQL);

        if ($ExecuteMetaSQL) {
            $msg = "Meta Information updated successfully.";
        } else {
            if (DEBUG) {
                echo "ExecuteMetaSQL error" . mysqli_error($con);
            }
            $err = "Meta Information could not updated";
        }
    }
}

//fetching product general information from db
$sqlProduct = "SELECT * FROM products WHERE product_id='$pid'";
$executeProduct = mysqli_query($con, $sqlProduct);
if ($executeProduct) {
  $getProduct = mysqli_fetch_object($executeProduct);
  if (isset($getProduct->product_id)) {
    
    $mtitle = $getProduct->product_meta_title;
    $key = $getProduct->product_meta_keywords;
    $mdesc = $getProduct->product_meta_description;
    $title = $getProduct->product_title;
    $invID = $getProduct->product_default_inventory_id;
    
    if($invID > 0){
      $inventorySql = "SELECT product_inventories.PI_inventory_title, product_inventories.PI_current_price, 
                      product_images.PI_file_name 

                      FROM product_inventories 

                      LEFT JOIN product_images ON product_images.PI_inventory_id=product_inventories.PI_id 
                      WHERE product_inventories.PI_id = ".  intval($invID);
      $inventoryResult = mysqli_query($con, $inventorySql);
      if($inventoryResult){
          $inventoryResultRowObj = mysqli_fetch_object($inventoryResult);
          if(isset($inventoryResultRowObj->PI_inventory_title)){
            $current_price = $inventoryResultRowObj->PI_current_price;
            $default_title = $inventoryResultRowObj->PI_inventory_title;
            $default_image = $inventoryResultRowObj->PI_file_name;
          }
      }
    }
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Meta</title>

        <?php include basePath('admin/header.php');?>


        <!--Effect on left error menu, top message menu, body-->
        <!--delete tags-->
        <script type="text/javascript">
            /*function del(pin_id1)
             {
             if(confirm('Are you sure to delete this tag!!'))
             {
             window.location='index.php?del='+pin_id1;
             }
             }*/
        </script>
        <!--end delete tags-->
        <script type="text/javascript">
            function redirect()
            {
                if (confirm('Do you want to leave Product Editing Module?'))
                {
                    window.location = "../index.php";
                }
            }

        </script>
    </head>


    <body>


<?php include basePath('admin/top_navigation.php'); ?>

<?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
            <div class="leftNav">
<?php include('left_navigation.php'); ?>
            </div>
            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Product's Meta Information</h5></div>

                <!-- Notification messages -->
<?php include basePath('admin/message.php'); ?>
<!-- Website statistics -->
                <div class="widget">
                    <div class="head"><h5 class="iChart8">Product basic information</h5></div>
                    <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic"> 
                        <tbody>
                            <tr>
                                <td style="width:30%"><a href="#" title="">Product Title</a></td>
                                <td><?php echo $title;?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="" >Product Default Inventory Title</a></td>
                                <td><?php if($default_title == ''){ echo '<p style="color: red;"><b>Default Inventory is not set</b></p>'; } else { echo $default_title; } ?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Current Price</a></td>
                                <td><?php if($default_title == ''){ echo '<p style="color: red;"><b>Default Inventory is not set</b></p>'; } else { echo $current_price; }?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Default Image</a></td>
                                <td><?php if($default_image == ''){ echo '<p style="color: red;"><b>Default Image is not set</b></p>'; } else { echo '<a target="_blank" href="' . baseUrl('upload/product/mid/' . $default_image) . '">Image Link</a>'; }?></td>
                            </tr>
                        </tbody>
                    </table>                            
                </div>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Meta Information</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="meta.php?pid=<?php echo base64_encode($pid); ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Meta Information</h5></div>
                                        <div class="rowElem noborder"><label>Meta Title:</label><div class="formRight">
                                                <input name="mtitle" type="text" value="<?php echo $mtitle; ?>"/>
                                            </div><div class="fix"></div></div>
                                        <div class="rowElem noborder"><label>Meta Keyword:</label><div class="formRight">
                                                <input name="key" type="text" value="<?php echo $key; ?>"/>
                                            </div><div class="fix"></div></div>
                                        <div class="head"><h5 class="iPencil">Meta Description:</h5></div>      
                                        <div><textarea class="tm" rows="5" cols="" name="mdesc"><?php echo $mdesc;?></textarea></div>


                                        <input type="submit" name="update" value="Update Product Details" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>

                            </form>		


                        </div>










                    </div>
                </div>

            </div>
            <!-- Content End -->

            <div class="fix"></div>
        </div>

<?php include basePath('admin/footer.php'); ?>

