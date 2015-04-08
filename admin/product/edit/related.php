<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id');

//saving tags in database

$pid = base64_decode($_GET['pid']);
$current_price = '';
$default_title = '';
$default_image = '';


if (isset($_POST['update'])) {

    extract($_POST);
    if (isset($_POST['product'])) { //checking if checkbox submitted
        $proin = implode(',', $product);
        $delpro = mysqli_query($con, "DELETE FROM products_related WHERE PR_current_product_id='$pid' AND PR_related_product_id NOT IN($proin)");

        $getid = mysqli_query($con, "SELECT PR_related_product_id FROM products_related WHERE PR_current_product_id='$pid'");
        $countrow = mysqli_num_rows($getid);

        if ($countrow > 0) {
            while ($rowid = mysqli_fetch_object($getid)) {
                $proiddb[] = $rowid->PR_related_product_id;
            }
            $diff = array_diff($product, $proiddb); //getting the difference between submitted id and existing id
            foreach ($diff as $products) { //getting product id from array
                //echo $proin = implode(',',$product);
                $pid = base64_decode($_GET['pid']); //product id
                $p = "priority" . $products; //getting priority variable name for the product selected
                $priority = $$p; //getting priority value from created variable
                $saverelated = mysqli_query($con, "INSERT INTO products_related(PR_current_product_id,PR_related_product_id,PR_priority_id,PR_created_by_id) VALUES('$pid','$products','$priority','$aid')");

                if ($saverelated) {
                    $msg = "Successfully saved";
                } else {
                    $err = "Could not save.";
                }
            }
        } else {
            foreach ($product as $products) { //getting product id from array
                //echo $proin = implode(',',$product);
                $pid = base64_decode($_GET['pid']); //product id
                $p = "priority" . $products; //getting priority variable name for the product selected
                $priority = $$p; //getting priority value from created variable
                $saverelated = mysqli_query($con, "INSERT INTO products_related(PR_current_product_id,PR_related_product_id,PR_priority_id,PR_created_by_id) VALUES('$pid','$products','$priority','$aid')");

                if ($saverelated) {
                    $msg = "Successfully saved";
                } else {
                    $err = "Could not save.";
                }
            }
        }
    }
}


$sql = "SELECT * FROM products
LEFT JOIN products_related ON products_related.PR_related_product_id = products.product_id
WHERE product_id != $pid
";
$prosel = mysqli_query($con, $sql);
//fetching product general information from db
$sqlProduct = "SELECT * FROM products WHERE product_id='$pid'";
$executeProduct = mysqli_query($con, $sqlProduct);
if ($executeProduct) {
    $getProduct = mysqli_fetch_object($executeProduct);
    if (isset($getProduct->product_id)) {
        $title = $getProduct->product_title;
        $invID = $getProduct->product_default_inventory_id;

        if ($invID > 0) {
            $inventorySql = "SELECT product_inventories.PI_inventory_title, product_inventories.PI_current_price, 
                      product_images.PI_file_name 

                      FROM product_inventories 

                      LEFT JOIN product_images ON product_images.PI_inventory_id=product_inventories.PI_id 
                      WHERE product_inventories.PI_id = " . intval($invID);
            $inventoryResult = mysqli_query($con, $inventorySql);
            if ($inventoryResult) {
                $inventoryResultRowObj = mysqli_fetch_object($inventoryResult);
                if (isset($inventoryResultRowObj->PI_inventory_title)) {
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
        <title>Admin Panel |Related Product</title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css --> 
        <script>
            function related(str)
            {
                var id = document.frm1.pid.value;

                if (str == "")
                {
                    document.getElementById("txtHint").innerHTML = "";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function()
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
                    {
                        document.getElementById("shwClr").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "ajaxcat.php?c=" + str + "&id=" + id, true);
                xmlhttp.send();
            }
        </script>

        <!--Effect on left error menu, top message menu, body-->
        <!--delete tags-->

        <!--select box script-->
        <script type="text/javascript">
            checked = false;
            function checkedAll(frm1) {
                var aa = document.getElementById('frm1');
                if (checked == false)
                {
                    checked = true
                }
                else
                {
                    checked = false
                }
                for (var i = 0; i < aa.elements.length; i++)
                {
                    aa.elements[i].checked = checked;
                }
            }
        </script>
        <!--end select box script-->

        <!--redirect tags-->
        <script type="text/javascript">
            function redirect()
            {
                if (confirm('Do you want to leave Product Editing Module?'))
                {
                    window.location = "../index.php";
                }
            }

        </script>
        <!--end redirect tags-->

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
                <div class="title"><h5>Related Product Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Website statistics -->
                <div class="widget">
                    <div class="head"><h5 class="iChart8">Product basic information</h5></div>
                    <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic"> 
                        <tbody>
                            <tr>
                                <td style="width:30%"><a href="#" title="">Product Title</a></td>
                                <td><?php echo $title; ?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="" >Product Default Inventory Title</a></td>
                                <td><?php
                                    if ($default_title == '') {
                                        echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
                                    } else {
                                        echo $default_title;
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Current Price</a></td>
                                <td><?php
                                    if ($default_title == '') {
                                        echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
                                    } else {
                                        echo $current_price;
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Default Image</a></td>
                                <td><?php
                                    if ($default_image == '') {
                                        echo '<p style="color: red;"><b>Default Image is not set</b></p>';
                                    } else {
                                        echo '<a target="_blank" href="' . baseUrl('upload/product/mid/' . $default_image) . '">Image Link</a>';
                                    }
                                    ?></td>
                            </tr>
                        </tbody>
                    </table>                            
                </div>
                <!-- Charts -->


                <form id ="frm1" action="related.php?pid=<?php echo $_GET['pid']; ?>" method="post">            
                    <div class="table">
                        <div class="head">
                            <h5 class="iFrames">Related Product List</span></h5></div>
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
                            <thead>
                                <tr>
                                    <td style="mystyle">Select</td>
                                    <th>Product Size</th>
                                    <th>Product Updated By</th>
                                    <th>Set Priority</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <?php
                                        while ($prorow = mysqli_fetch_array($prosel)) {
                                            ?>                        

                                    <tr class="gradeA">
                                        <td><input type="checkbox" name="product[]" value="<?php echo $prorow['product_id']; ?>" <?php
                                        if ($prorow['PR_current_product_id'] > 0) {
                                            echo "checked";
                                        }
                                            ?>/></td>
                                        <td><?php echo $prorow['product_title']; ?></td>
                                        <td><?php echo $prorow['product_short_description']; ?></td>
                                        <td style="width:80px !important"><input name="priority<?php echo $prorow['product_id']; ?>" type="text" style="width:50px !important" maxlength="3" value="<?php echo $prorow['PR_priority_id']; ?>" /></td>
                                    </tr>
    <?php
}
?>
                            </tbody>
                        </table>
                        <input type="submit" name="update" value="Update" class="greyishBtn submitForm" />
                        <div class="fix"></div>
                    </div>
                </form>
            </div>
        <!-- Content End -->

        <div class="fix"></div>
        </div>

<?php include basePath('admin/footer.php'); ?>
        <script type="text/javascript">

            $(document).ready(function() {
                var oTable = $('#example2').dataTable({
                    "sPaginationType": "full_numbers"
                });
                $('#frm1').live('submit', function() {
                    var nNodes = oTable.fnGetNodes( );
                    
                   $(nNodes).find('input').appendTo(this).css('display','none');

                });

            });



        </script>
