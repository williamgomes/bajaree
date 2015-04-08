<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id'); //get admin id
$pid = base64_decode($_GET['pid']);

//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE product_inventories SET PI_status='active' WHERE PI_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $product_default_inventory_id = getFieldValue('products','product_default_inventory_id','product_default_inventory_id='.$InactID);
    if(!is_numeric($product_default_inventory_id)){
    $sqlInactivate = "UPDATE product_inventories SET PI_status='inactive' WHERE PI_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);        
    }else{
        $err = 'Default inventory cant be inactivated';
    }

}

/** Start: Get the color for product for inventory * */
$query_for_inventory_color = "SELECT
    c.color_id,c.color_title,c.color_code
FROM
    colors c
WHERE c.color_id IN(SELECT PI_color FROM product_images WHERE PI_product_id=" . intval($pid) . ")";
$sqlcolor = mysqli_query($con, $query_for_inventory_color);
/** End: Get the color for product for inventory * */
$quan = '';
$weight = '';
$cost = 0;
$oldprice = 0;
$currentprice = 0;
$title = '';
$color = 0;
$size = 0;
$current_price = '';
$default_title = '';
$default_image = '';

if (isset($_POST['update'])) {
    extract($_POST);
    $err = "";
    $msg = "";


    if ($title == "") {
        $err = "Inventory Title is required.";
    } elseif ($quan == "") {
        $err = "Product Quantity is required.";
    } elseif ($size == 0) {
        $err = "Product Size is required.";
    } elseif ($color == 0) {
        $err = "Product color is required.";
    } elseif ($cost == "") {
        $err = "Product Cost is required.";
    } elseif (!is_numeric($cost)) {
        $err = "Product Cost can only be numeric.";
    } elseif (!empty($currentprice)) {

        if (!ctype_digit($currentprice)) {
            $err = "Product Current Price can only be numeric.";
        } else {
            goto UpdateInventorySection;
        }
    } else {
        UpdateInventorySection:
        if ($currentprice == "") {
            $currentprice = 0;
        }
        $query_of_checkDuplicateInventoryItem = "SELECT * FROM product_inventories WHERE PI_product_id='" . intval($pid) . "' AND PI_inventory_title='" . mysqli_real_escape_string($con, $title) . "' AND PI_size_id='" . intval($size) . "' AND PI_color_id='".intval($color)."'";
        $result_of_checkDuplicateInventoryItem = mysqli_query($con, $query_of_checkDuplicateInventoryItem);

        if (mysqli_num_rows($result_of_checkDuplicateInventoryItem) > 0) {
            $err = "Same Inventory Title, Colour & Size already exists";
        } else {
            $UpdateInventory = '';
            $UpdateInventory .= ' PI_product_id = "' . mysqli_real_escape_string($con, $pid) . '"';
            $UpdateInventory .= ', PI_color_id = "' . mysqli_real_escape_string($con, $color) . '"';
            $UpdateInventory .= ', PI_size_id = "' . mysqli_real_escape_string($con, $size) . '"';
            $UpdateInventory .= ', PI_quantity = "' . mysqli_real_escape_string($con, $quan) . '"';
            $UpdateInventory .= ', PI_inventory_title = "' . mysqli_real_escape_string($con, $title) . '"';
            $UpdateInventory .= ', PI_cost = ' . floatval($cost);
            $UpdateInventory .= ', PI_old_price = ' . floatval($oldprice);
            $UpdateInventory .= ', PI_current_price = ' . floatval($currentprice);
            $UpdateInventory .= ', PI_updated_by = "' . mysqli_real_escape_string($con, $aid) . '"';

            $UpdateInventorySQL = "INSERT INTO product_inventories SET $UpdateInventory";
            $ExecuteInventory = mysqli_query($con, $UpdateInventorySQL);

            if ($ExecuteInventory) {
                $PI_id = mysqli_insert_id($con);
                /* Start log */

                if ($PI_id > 0) {
                    $initialSqlEntryField = "";
                    $initialSqlEntryField .="PIL_PI_id= " . $PI_id;
                    $initialSqlEntryField .=",PIL_date= '" . date("Y-m-d") . "'";
                    $initialSqlEntryField .=",PIL_in_qty= " . intval($quan);
                    $initialSqlEntryField .=",PIL_note= 'Inserted initial value '";
                    $initialSqlEntryField .=",PIL_created_by= " . $aid;
                    $initialSqlEntryField .=",PIL_created_date= '" . date("Y-m-d H:i:s") . "'";
                    $initialSql = "INSERT INTO product_inventory_log SET $initialSqlEntryField ";
                    $initialSqlResult = mysqli_query($con, $initialSql);
                    if ($initialSqlResult) {
                        //sucess
                    } else {
                        if (DEBUG) {
                            $err = "initialSqlResult Error:  " . mysqli_error($con);
                        } else {
                            $err = "initialSqlResult query Fail ";
                        }
                    }
                }
                /* End log */

                $msg = "Product Inventory Information added successfully.";
            } else {
                if (DEBUG) {
                    echo "ExecuteGeneralInfo error" . mysqli_error($con);
                }
                $err = "Product Inventory Information could not added";
            }
        }
    }
}



/** Start : Query for product inventory Grid * */
$arrayInventory = array();
$sqlGetInventory = "SELECT s.size_title,piv.PI_quantity,piv.PI_inventory_title,piv.PI_cost,piv.PI_current_price,piv.PI_status,a.admin_full_name,piv.PI_id
                    FROM product_inventories piv,sizes s,admins a
                    WHERE piv.PI_size_id= s.size_id 
                    AND piv.PI_updated_by =a.admin_id 
                    AND PI_product_id='" . $pid . "'";
$executeGetInventory = mysqli_query($con, $sqlGetInventory);
if ($executeGetInventory) {
    while ($executeGetInventoryObj = mysqli_fetch_object($executeGetInventory)) {
        $arrayInventory[] = $executeGetInventoryObj;
    }
} else {
    if (DEBUG) {
        echo "executeGetInventory error: " . mysqli_error($con);
    }
}

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
/** End : Query for product inventory Grid * */
//$pid = $_GET['pid'];
//$product = mysqli_query($con, "SELECT * FROM products WHERE product_id='$pid'");
//$rowproduct = mysqli_fetch_array($product);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Product Inventory</title>

        <?php include basePath('admin/header.php'); ?>  
        <script>
            function getColorCodeOrImage(colorId)
            {
                $.ajax({
                    type: "POST",
                    url: "ajaxcolor.php",
                    data: {color_id: colorId},
                    success: function(result) {
                        //alert(result);
                        $("#shwClr").html('');
                        $("#shwClr").html(result);
                    }
                });
            }
        </script>   
        <script type="text/javascript">
            function redirect()
            {
                if (confirm('Do you want to leave Product Editing Module?'))
                {
                    window.location = "../index.php";
                }
            }

        </script>        
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
            <div class="leftNav">
<?php include('left_navigation.php'); ?>
            </div>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Inventory Module</h5></div>

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
                                <td><?php if ($default_title == '') {
    echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
} else {
    echo $default_title;
} ?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Current Price</a></td>
                                <td><?php if ($default_title == '') {
    echo '<p style="color: red;"><b>Default Inventory is not set</b></p>';
} else {
    echo $current_price;
} ?></td>
                            </tr>
                            <tr>
                                <td ><a href="#" title="">Product Default Image</a></td>
                                <td><?php if ($default_image == '') {
    echo '<p style="color: red;"><b>Default Image is not set</b></p>';
} else {
    echo '<a target="_blank" href="' . baseUrl('upload/product/mid/' . $default_image) . '">Image Link</a>';
} ?></td>
                            </tr>
                        </tbody>
                    </table>                            
                </div>
                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Inventory</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="inventory.php?pid=<?php echo $_GET['pid']; ?>" method="post" class="mainForm">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Product Inventory For <strong><?php echo getFieldValue($tableNmae = 'products', $fieldName = 'product_title', $where = 'product_id=' . $pid) ?></strong></h5></div>

                                        <div class="rowElem noborder"><label>Inventory Title:</label><div class="formRight">
                                                <input name="title" type="text" value="<?php echo $title; ?>" />
                                            </div><div class="fix"></div></div>

                                        <div class="rowElem noborder"><label>Product Quantity:</label><div class="formRight">
                                                <input name="quan" type="text" value="<?php echo $quan; ?>" maxlength="20" />
                                            </div><div class="fix"></div></div>


                                        <div class="rowElem">
                                            <label>Product Color :</label>
                                            <div class="formRight">
                                                <div id="colors">
                                                    <select name="color"  onchange="getColorCodeOrImage(this.value)">
                                                        <option value="0">Select Product Color</option>	
                                                        <?php
                                                        /** Start: get Color by product id * */
                                                        if ($edit = 0) {
                                                            $query_for_product_color = "SELECT
                                c.color_id,c.color_title,c.color_code
                            FROM
                                colors c ORDER BY c.color_title ASC";
                                                        } else {

                                                            $query_for_product_color = "SELECT
                                c.color_id,c.color_title,c.color_code
                            FROM
                                colors c ORDER BY c.color_title ASC";
                                                        }
                                                        $result_of_product_color = mysqli_query($con, $query_for_product_color);
                                                        /** End: get Color by product id * */
                                                        if ($result_of_product_color) {
                                                            while ($rows = mysqli_fetch_object($result_of_product_color)) {
                                                                ?>
                                                                <option value="<?php echo $rows->color_id; ?>" <?php if ($color == $rows->color_id) echo 'selected="selected"' ?>><?php echo $rows->color_title; ?></option>
        <?php
    }
}
?>
                                                    </select>
                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="shwClr"  style="position:relative; left:170px; bottom:10px">Select a color.</div>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>

                                        </div>

                                        <div class="rowElem">
                                            <label>Product Size :</label>
                                            <div class="formRight">
                                                <select name="size" >
                                                    <option value="0">Select Product Size</option>
<?php
$sqlsiz = mysqli_query($con, "SELECT * FROM product_sizes WHERE PS_product_id=" . intval($pid));
while ($rowsiz = mysqli_fetch_object($sqlsiz)) {
    ?>
                                                        <option value="<?php echo $rowsiz->PS_size_id; ?>" <?php if ($size == $rowsiz->PS_size_id) echo 'selected="selected"'; ?>><?php echo $rowsiz->PS_size_title; ?></option>
    <?php
}
?>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="rowElem noborder"><label>Product Cost:</label><div class="formRight">
                                                <input name="cost" type="text" value="<?php echo $cost; ?>" maxlength="20"/>
                                            </div><div class="fix"></div></div>

                                        <div class="rowElem noborder"><label>Product Old Price:</label><div class="formRight">
                                                <input name="oldprice" type="text" value="<?php echo $oldprice; ?>" maxlength="20"/>
                                            </div><div class="fix"></div></div>

                                        <div class="rowElem noborder"><label>Product Current Price:</label><div class="formRight">
                                                <input name="currentprice" type="text" value="<?php echo $currentprice; ?>" maxlength="20"/>
                                            </div><div class="fix"></div></div>



                                        <input type="submit" name="update" value="Update Inventory Details" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>

                            </form>		


                        </div>

<?php ?>                        
                        <div class="table">
                            <div class="head">
                                <h5 class="iFrames">Inventory List For <?php echo getFieldValue($tableNmae = 'products', $fieldName = 'product_title', $where = 'product_id=' . $pid) ?></h5></div>
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>Inventory ID</th>
                                        <th>Inventory Title</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Cost</th>
                                        <th>Current Price</th>
                                        <th>Status</th>
                                        <th>Updated By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$countInventoryArray = count($arrayInventory);
if ($countInventoryArray > 0) {
    for ($i = 0; $i < $countInventoryArray; $i++) {
        ?>                        

                                            <tr class="gradeA">
                                                <td><?php echo $arrayInventory[$i]->PI_id; ?></td>
                                                <td><?php echo $arrayInventory[$i]->PI_inventory_title; ?></td>
                                                <td><?php echo $arrayInventory[$i]->size_title; ?></td>
                                                <td><?php echo $arrayInventory[$i]->PI_quantity; ?></td>
                                                <td><?php echo $arrayInventory[$i]->PI_cost; ?></td>
                                                <td><?php echo $arrayInventory[$i]->PI_current_price; ?></td>
                                                <td class="center">
                                            <?php
                                            if ($arrayInventory[$i]->PI_status == 'active') {
                                                echo '<a href="javascript:inactive(' . $arrayInventory[$i]->PI_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                            } else {
                                                echo '<a href="javascript:active(' . $arrayInventory[$i]->PI_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                            }
                                            ?>
                                        </td>
                                                <td><?php echo $arrayInventory[$i]->admin_full_name; ?></td>
                                                <td><a href="edit_inventory.php?pid=<?php echo $_GET['pid']; ?>&inv_id=<?php echo base64_encode($arrayInventory[$i]->PI_id); ?>" title="Edit"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png'); ?>" height="18" width="18" alt="Edit" /></a></td>
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
        <script type="text/javascript">
            function active(pin_id) {
                jConfirm('You want to ACTIVATE this?', 'Confirmation Dialog', function(r) {
                    if (r) {
                        /*alert(r);*/
                        window.location.href = 'inventory.php?actid=' + pin_id+'&pid=<?php echo base64_encode($pid);?>';
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
                        window.location.href = 'inventory.php?inactid=' + pin_id+'&pid=<?php echo base64_encode($pid);?>';
                    }
                });
            }

            $(document).ready(function() {
                $("#sortByCat").live('change', function() {
                    var sortByCatId = $(this).val();
                    //alert(sortByCatId);
                    window.location.href = 'inventory.php?sortBy=' + sortByCatId+'&pid=<?php echo base64_encode($pid);?>';
                });
            });
        </script>

<?php include basePath('admin/footer.php');

