<?php
include ('../../config/config.php');
include '../../lib/category2.php';
$cat2DD = new Category2($con); /* $cat2DD == category2 library dropdown */
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id');

//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE product_inventories SET PI_status='active' WHERE PI_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
    $link = "";
    $link .= "bookmark.php";
    if(isset($_GET['bookmark'])){
      $link .= "?bookmark=" . $_GET['bookmark'];
    }
    redirect($link);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE product_inventories SET PI_status='inactive' WHERE PI_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
    $link = "";
    $link .= "bookmark.php";
    if(isset($_GET['bookmark'])){
      $link .= "?bookmark=" . $_GET['bookmark'];
    }
    redirect($link);
}


//checking for sortBy id



$bookmarkID = 0;
$productArray = array();
if (isset($_GET['bookmark'])) {
    $bookmarkID = $_GET['bookmark'];
    $productInventorySql = "SELECT * FROM product_inventories LEFT JOIN products ON product_id=PI_product_id WHERE PI_bookmark_id=$bookmarkID";
}else{
    $productInventorySql = "SELECT * FROM product_inventories LEFT JOIN products ON product_id=PI_product_id WHERE PI_bookmark_id>0";
}

$productInventorySqlResult = mysqli_query($con, $productInventorySql);
if ($productInventorySqlResult) {
    while ($productInventorySqlResultObj = mysqli_fetch_object($productInventorySqlResult)) {
        $productArray[] = $productInventorySqlResultObj;
    }
} else {
    if (DEBUG) {
        echo "productInventorySqlResult error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Product Module</title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->    

        <!--Effect on left error menu, top message menu, body-->
        <!-- Activation Script -->
        <script type="text/javascript">
            function active(pin_id) {
                jConfirm('You want to ACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'bookmark.php?<?php echo $_SERVER['QUERY_STRING']; ?>&actid=' + pin_id;
                    }
                });
            }
        </script>
        <!--Activation Script -->

        <!-- Deactivation Script -->
        <script type="text/javascript">
            function inactive(pin_id) {
                jConfirm('You want to DEACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'bookmark.php?<?php echo $_SERVER['QUERY_STRING']; ?>&inactid=' + pin_id;
                    }
                });
            }

            $(document).ready(function() {
                $("#sortByCat").live('change', function() {
                    var sortByCatId = $(this).val();
                    //alert(sortByCatId);
                    window.location.href = 'bookmark.php?bookmark=' + sortByCatId;
                });
            });
        </script>
        <!--Deactivation Script -->
        
     


        <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
        <link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
                <div class="title"><h5>Product Catalogue Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->

                <div class="widget">    
                    <div class="rowElem">
                        <label>Sort by category  :</label>
                        <div class="formRight">
                            <select name="bookmarkID"  id="sortByCat">
                                <option value="<?php echo $config['BOOKMARK_CATEGORY_ID']; ?>">All Bookmark</option>
                                <?php echo $cat2DD->viewDropdown($config['BOOKMARK_CATEGORY_ID']); ?>
                            </select>
                        </div>
                        <div class="fix"></div>
                    </div>
                </div>
                
                
                <div class="table">
                    <div class="head">
                        <h5 class="iFrames">Product Catalogue</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Inventory Title</th>
                                <th>Cost</th>
                                <th>Price</th>
                                <th>Updated By</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $productArrayCounter = count($productArray);
                            if ($productArrayCounter > 0):
                                ?>
                                <?php for ($i = 0; $i < $productArrayCounter; $i++): ?>

                                    <tr class="gradeA">
                                        <td><?php echo $productArray[$i]->product_title; ?></td>
                                        <td><?php echo $productArray[$i]->PI_inventory_title; ?></td>
                                        <td id="cost_data_<?php echo $productArray[$i]->PI_id; ?>"><a href="javascript:resetCost(<?php echo $productArray[$i]->PI_id; ?>,<?php echo $productArray[$i]->PI_cost; ?>);" ><?php echo $productArray[$i]->PI_cost; ?></a></td>
                                        <td id="price_data_<?php echo $productArray[$i]->PI_id; ?>"><a href="javascript:resetPrice(<?php echo $productArray[$i]->PI_id; ?>,<?php echo $productArray[$i]->PI_current_price; ?>);" ><?php echo $productArray[$i]->PI_current_price; ?></a></td>
                                        <td><?php
                                            $adminid = $productArray[$i]->PI_updated_by;
                                            $adminsql = mysqli_query($con, "SELECT (admin_full_name) FROM admins WHERE admin_id='$adminid'");
                                            $adminrow = mysqli_fetch_array($adminsql);
                                            echo $adminrow[0];
                                            ?></td>
                                        <td class="center">
                                            <?php
                                            if ($productArray[$i]->PI_status == 'active') {
                                                echo '<a href="javascript:inactive(' . $productArray[$i]->PI_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                            } else {
                                                echo '<a href="javascript:active(' . $productArray[$i]->PI_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endfor; /* $i=0; i<$adminArrayCounter; $++  */ ?>
                            <?php endif; /* count($adminArray) > 0 */ ?>
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
<script type="text/javascript">

function resetCost(inventory_id, product_cost) {


    var new_cost = prompt("Priority reset ", product_cost);
    var table_name = 'product_inventories';
    var update_field = 'PI_cost';
    var where_condition = 'PI_id='+inventory_id;
    if (new_cost == product_cost)
    {
        //do nothing 
        //  $.jGrowl('Status could not update  ');
    } else if (new_cost > 0) {
        //call ajax 

        $.post("../ajax/ajax.InventoryUpdate.php", {id: inventory_id, new_cost: new_cost,table_name:table_name,update_field:update_field,where_condition:where_condition, action:"costUpdate"}, function(output) {
            
            var result = $.parseJSON(output);
            if (result.error == 0) {
                //No error
                $("td#cost_data_" + inventory_id).html('<a href="javascript:resetCost(' + inventory_id + ',' + new_cost + ');">' + new_cost + '</a>');
                $.jGrowl('Cost updated successfully ');
            } else if (result.error == 1) {
                //Query failed
                $.jGrowl('Cost could not update  ');
            } else {
                $.jGrowl(result.message);
            }
        });
    } else {
        // do nothink 
        $.jGrowl('Cost could not update  ');
    }
}




function resetPrice(inventory_id, product_price) {


    var new_price = prompt("Priority reset ", product_price);
    var table_name = 'product_inventories';
    var update_field = 'PI_current_price';
    var where_condition = 'PI_id='+inventory_id;
    if (new_price == product_price)
    {
        //do nothing 
        //  $.jGrowl('Status could not update  ');
    } else if (new_price > 0) {
        //call ajax 

        $.post("../ajax/ajax.InventoryUpdate.php", {id: inventory_id, new_price: new_price,table_name:table_name,update_field:update_field,where_condition:where_condition, action:"priceUpdate"}, function(output) {
            
            var result = $.parseJSON(output);
            if (result.error == 0) {
                //No error
                $("td#price_data_" + inventory_id).html('<a href="javascript:resetPrice(' + inventory_id + ',' + new_price + ');">' + new_price + '</a>');
                $.jGrowl('Price updated successfully ');
            } else if (result.error == 1) {
                //Query failed
                $.jGrowl('Price could not update  ');
            } else {
                $.jGrowl(result.message);
            }
        });
    } else {
        // do nothink 
        $.jGrowl('Price could not update  ');
    }
}

</script>

