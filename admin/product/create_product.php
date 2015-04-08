<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = @getSession('admin_id');

$title = "";
$desc = "";
$sku = "";
$price = "";

$newfrom = date('Y-m-d', strtotime('-2 days'));
$newto = date('Y-m-d', strtotime('-1 days'));

$featuredfrom = date('Y-m-d', strtotime('-2 days'));
$featuredto = date('Y-m-d', strtotime('-1 days'));

$product_priority = 0;
//saving tags in database

if (isset($_POST['submit'])) {
    extract($_POST);
    $err = "";
    $msg = "";
    
    if (!preg_match("/([A-Za-z0-9]+)/", $title)) {
        $err .= "Only numbers & alphabets are allowed for Product Title";
    } else if ($price < 0) {
        $err = "Product Price must be grater than 0.";
    } else if ($product_priority < 0 && $product_priority > 5) {
        $err = "Product rating will be between 0 to 5";
    } else {

        $ProductCreate = '';
        $ProductCreate .= ' product_title = "' . mysqli_real_escape_string($con, $title) . '"';
        $ProductCreate .= ', product_long_description = "' . mysqli_real_escape_string($con, $desc) . '"';
        $ProductCreate .= ', product_priority = "' . mysqli_real_escape_string($con, $product_priority) . '"';
        
        $ProductCreate .= ', product_show_as_new_from = "' .$newfrom . '"';
        $ProductCreate .= ', product_show_as_new_to = "' .$newto . '"';
        
        $ProductCreate .= ', product_show_as_featured_from = "' .$featuredfrom . '"';
        $ProductCreate .= ', product_show_as_featured_to = "' .$featuredto . '"';
        
        $ProductCreate .= ', product_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

        $CreateProductSql = "INSERT INTO products SET $ProductCreate";
        $ExecuteCreateProduct = mysqli_query($con, $CreateProductSql);
        $InsertedProductID = mysqli_insert_id($con);

        if ($ExecuteCreateProduct) {
            $msg = "Product created successfully";
            $link = baseUrl('admin/product/edit/index.php?pid=' . base64_encode($InsertedProductID) . '&msg=' . base64_encode($msg));
            redirect($link);
        } else {
            if (DEBUG) {
                echo 'ExecuteCreateProduct Error: ' . mysqli_error($con);
            }
            $err = "Product Creation failed.";
        }
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Create Product </title>

<?php include basePath('admin/header.php'); ?>
       

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


        
    </head>

    <body>


<?php include basePath('admin/top_navigation.php'); ?>

        <?php include basePath('admin/module_link.php'); ?>


        <!-- Content wrapper -->
        <div class="wrapper">

            <!-- Left navigation -->
<?php include ('product_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Product Module</h5></div>

                <!-- Notification messages -->
<?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Product</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="create_product.php" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                  <div class="widget first">
                                    <div class="head">
                                      <h5 class="iList">Add Product</h5></div>
                                    <div class="rowElem noborder"><label>Product Title:</label><div class="formRight"><span id="sprytextfield1">                                         <input name="title" type="text" value="<?php echo $title; ?>"/>
                                        </span></div><div class="fix"></div></div>



                                    <div class="head"><h5 class="iPencil">Long Description:</h5></div>      
                                    <div><textarea class="tm" rows="5" cols="" name="desc"><?php echo $desc; ?></textarea></div>



                                    
                                    <div class="rowElem noborder"><label>Product Avg. Rating:</label><div class="formRight"><span id="sprytextfield3"><span id="sprytextfield4">
                                            <input name="product_priority" type="text" maxlength="1" value="<?php echo $product_priority; ?>"/>
                                          </span></span></div><div class="fix"></div></div>

                                    <input type="submit" name="submit" value="Add Product" class="greyishBtn submitForm" />
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
        <script type="text/javascript">
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none");
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency", {minValue: 1});
            var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer", {minValue: 0, maxValue: 5});
        </script>
