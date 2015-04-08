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
    $sqlActivate = "UPDATE products SET product_status='active' WHERE product_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE products SET product_status='inactive' WHERE product_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
}


//checking for sortBy id




$productArray = array();
if (isset($_GET['sortBy'])) {
    $childs=array();
    $sortBy = intval($_GET['sortBy']);
    $childs[]=$sortBy;
    $cat2DD->selected= $sortBy;
    $childsArray = $cat2DD->getChilds($sortBy);
    if(count($childs)){
        foreach($childsArray AS $child){
            $childs[]=$child['category_id'];
        }
    }
    asort($childs);
    $childString = implode(',', $childs);
    $productSql = "SELECT * FROM products LEFT JOIN product_categories ON product_categories.PC_product_id = products.product_id WHERE  product_status='active' AND product_categories.PC_category_id IN ($childString)";
}else{
    $productSql = "SELECT * FROM products WHERE product_status='active'";
}

$productSqlResult = mysqli_query($con, $productSql);
if ($productSqlResult) {
    while ($productSqlResultObj = mysqli_fetch_object($productSqlResult)) {
        $productArray[] = $productSqlResultObj;
    }
} else {
    if (DEBUG) {
        echo "$productSqlResult error: " . mysqli_error($con);
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
                        window.location.href = 'index.php?actid=' + pin_id;
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
                        window.location.href = 'index.php?inactid=' + pin_id;
                    }
                });
            }

            $(document).ready(function() {
                $("#sortByCat").live('change', function() {
                    var sortByCatId = $(this).val();
                    //alert(sortByCatId);
                    window.location.href = 'index.php?sortBy=' + sortByCatId;
                });
            });
        </script>
        <!--Deactivation Script -->
        
        
        <script type="text/javascript">
            function excelRelated() {
                var data = new Object();
                data.action = 'related';
                var url = 'ajax.RelatedData.php';
                //ajax
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(res) {
                        window.location = url;
                    },
                    error: function(res) {
                          //res = jQuery.parseJSON(res);
                        console.log( res);
                    }
                });
            return false;
            }
            
            
            
            
            function excelNotRelated() {
                var data = new Object();
                data.action = 'related';
                var url = 'ajax.NotRelatedData.php';
                //ajax
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(res) {
                        window.location = url;
                    },
                    error: function(res) {
                          //res = jQuery.parseJSON(res);
                        console.log( res);
                    }
                });
            return false;
            }
        </script>


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
                        <label>Excel Exporter  :</label>
                            <input type="button" value="Product Related Data" class="greyishBtn" onclick="excelRelated();" />
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="button" value="Other Data" class="greyishBtn" onclick="excelNotRelated();" />
                    </div>
                </div>

                <div class="widget">    
                    <div class="rowElem">
                        <label>Sort by category  :</label>
                        <div class="formRight">
                            <select name="sortByCat"  id="sortByCat">
                                <option value="<?php echo $config['PRODUCT_CATEGORY_ID']; ?>">All Product</option>
                                <?php echo $cat2DD->viewDropdown($config['PRODUCT_CATEGORY_ID']); ?>
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
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Priority</th>
                                <th>Updated By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $productArrayCounter = count($productArray);
                            if ($productArrayCounter > 0):
                                ?>
                                <?php for ($i = 0; $i < $productArrayCounter; $i++): ?>

                                    <tr class="gradeA">
                                        <td><?php echo $productArray[$i]->product_id; ?></td>
                                        <td><?php echo $productArray[$i]->product_title; ?></td>
                                        <td><?php echo $productArray[$i]->product_short_description; ?></td>
                                        <td id="priority_data_<?php echo $productArray[$i]->product_id; ?>"><a href="javascript:resetPriority(<?php echo $productArray[$i]->product_id; ?>,<?php echo $productArray[$i]->product_priority; ?>);" ><?php echo $productArray[$i]->product_priority; ?></a></td>
                                        <td><?php
                                            $adminid = $productArray[$i]->product_updated_by;
                                            $adminsql = mysqli_query($con, "SELECT (admin_full_name) FROM admins WHERE admin_id='$adminid'");
                                            $adminrow = mysqli_fetch_array($adminsql);
                                            echo $adminrow[0];
                                            ?></td>
                                        <td class="center">
                                            <?php
                                            if ($productArray[$i]->product_status == 'active') {
                                                echo '<a href="javascript:inactive(' . $productArray[$i]->product_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                            } else {
                                                echo '<a href="javascript:active(' . $productArray[$i]->product_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                            }
                                            ?>
                                        </td>
                                        <td class="center"><a href="edit/index.php?pid=<?php echo base64_encode($productArray[$i]->product_id); ?>" title="Edit"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png') ?>" height="14" width="14" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<!--<a href="javascript:del(<?php // echo $taxrow['TC_id'];    ?>);"><img src="../images/delete.png" /></a>--></td>
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

function resetPriority(product_id, product_priority) {


    var new_priority = prompt("Priority reset ", product_priority);
    var table_name = 'products';
    var update_field = 'product_priority';
    var where_condition = 'product_id='+product_id;
    if (new_priority == product_priority)
    {
        //do nothing 
        //  $.jGrowl('Status could not update  ');
    } else if (new_priority > 0) {
        //call ajax 

        $.post("../ajax/priority_update_product.php", {id: product_id, new_priority: new_priority,table_name:table_name,update_field:update_field,where_condition:where_condition}, function(result) {
            if (result == 0) {
                //No error
                $("td#priority_data_" + product_id).html('<a href="javascript:resetPriority(' + product_id + ',' + new_priority + ');">' + new_priority + '</a>');
                $.jGrowl('Priority updated successfully ');
            } else if (result == 1) {
                //Query failed
                $.jGrowl('Priority could not update  ');
            } else {
                $.jGrowl(result);
            }
        });
    } else {
        // do nothink 
        $.jGrowl('Priority could not update  ');
    }
}


</script>

