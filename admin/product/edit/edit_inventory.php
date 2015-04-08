<?php
include ('../../../config/config.php');
include ('../../../lib/category2.php');
$cat2DD = new Category2($con); /* $cat2DD == category2 library dropdown */

if (!checkAdminLogin()) {
  $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
  redirect($link);
}
$aid = getSession('admin_id'); //get admin id
$pid = base64_decode($_GET['pid']);
$InventoryID = base64_decode($_GET['inv_id']);
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
$cost = '';
$currentprice = 0;
$oldprice = 0;
$title = '';
$color = 0;
$size = 0;

/* Start inout */
$in_qty = '';
$out_qty = '';
$order_number = '';
$in_date = '';
$in_note = '';
$out_date = '';
$out_note = '';
$bookmark = 0;

/* End inout */
if (isset($_POST['update'])) {
  //printDie($_POST);
  extract($_POST);
  

  if ($title == "") {
    $err = "Product Title is required.";
  } elseif ($quan == "") {
    $err = "Product Quantity is required.";
  } elseif ($size == 0) {
    $err = "Product Size is required.";
  } elseif ($in_qty != '' && !is_numeric($in_qty)) {
    $err = "In quantiy filed valid number is required.";
  } elseif ($in_qty != '' && $in_date == '') {
    $err = "In date filed is required.";
  } elseif ($out_qty != '' && !is_numeric($out_qty)) {
    $err = "Out quantiy filed valid number is required.";
  } elseif ($out_qty != '' && $out_date == '') {
    $err = "Out date filed is required.";
  } elseif ($cost == "") {
    $err = "Product Cost is required.";
  } elseif (!is_numeric($cost)) {
    $err = "Product Cost can only be numeric.";
  } elseif ($currentprice == 0) {
    //printDie($_POST, TRUE);
    if (!ctype_digit($currentprice)) {
      $err = "Product Price can only be numeric.";
    } else {
      //die('heeee');
      goto UpdateInventorySection;
    }
  } else {
    //  printDie($_POST, TRUE);
    //die('222');
    UpdateInventorySection:
    if ($currentprice == "") {
      $currentprice = 0;
    }

    $query_of_checkDuplicateInventoryItem = "SELECT * FROM product_inventories WHERE PI_product_id='" . intval($pid) . "' AND PI_color_id='" . intval($color) . "' AND PI_size_id='" . intval($size) . "' AND PI_id!=" . intval($InventoryID);
    $result_of_checkDuplicateInventoryItem = mysqli_query($con, $query_of_checkDuplicateInventoryItem);

//    if (mysqli_num_rows($result_of_checkDuplicateInventoryItem) >= 1) {
//      $err = "same color,size product is already exists";
//    } else {
      $UpdateInventory = '';
      $UpdateInventory .= ' PI_color_id = ' . intval($color);
      $UpdateInventory .= ', PI_size_id = ' . intval($size);
      $UpdateInventory .= ', PI_quantity = ' . intval($quan);
      $UpdateInventory .= ', PI_inventory_title = "' . mysqli_real_escape_string($con, $title) . '"';
      $UpdateInventory .= ', PI_cost = ' . floatval($cost);
      $UpdateInventory .= ', PI_old_price = ' . floatval($oldprice);
      $UpdateInventory .= ', PI_bookmark_id = ' . intval($bookmark);
      $UpdateInventory .= ', PI_current_price = ' . floatval($currentprice);
      $UpdateInventory .= ', PI_updated_by = ' . intval($aid);

      $UpdateInventorySQL = "UPDATE product_inventories SET $UpdateInventory WHERE PI_id=" . intval($InventoryID);

      $ExecuteInventory = mysqli_query($con, $UpdateInventorySQL);

      if ($ExecuteInventory) {
        $msg = "Product Inventory Information added successfully.";
        if ($in_qty > 0) {
          $logFiled = '';
          $logFiled .=" PIL_PI_id = " . intval($InventoryID);
          $logFiled .=", PIL_date= '" . mysqli_real_escape_string($con, date_format(date_create($in_date), 'Y-m-d')) . "'";
          $logFiled .=", PIL_in_qty= '" . intval($in_qty) . "'";
          $logFiled .=", PIL_note='" . mysqli_real_escape_string($con, $in_note) . "'";
          $logFiled .=", PIL_created_by=" . intval($aid);
          $logFiled .=", PIL_created_date='" . date("Y-m-d H:i:s") . "'";
          $logInsSql = "INSERT INTO product_inventory_log SET $logFiled";
          $logInsResult = mysqli_query($con, $logInsSql);
          if ($logInsResult) {
            $msg = "Product Inventory Information added successfully.";
          }
        } elseif ($out_qty > 0) {
          $logFiled = '';
          $logFiled .=" PIL_PI_id = " . intval($InventoryID);
          $logFiled .=", PIL_out_qty= " . intval($out_qty);
          $logFiled .=", PIL_order_number= '" . mysqli_real_escape_string($con, $order_number) . "'";
          $logFiled .=", PIL_date='" . mysqli_real_escape_string($con, date_format(date_create($out_date), 'Y-m-d')) . "'";
          $logFiled .=", PIL_note='" . mysqli_real_escape_string($con, $out_note) . "'";
          $logFiled .=", PIL_created_by=" . intval($aid);
          $logFiled .=", PIL_created_date='" . date("Y-m-d H:i:s") . "'";
          $logInsSql = "INSERT INTO product_inventory_log SET $logFiled";
          $logInsResult = mysqli_query($con, $logInsSql);
          if ($logInsResult) {
            $msg = "Product Inventory Information added successfully.";
          }
        }
//      } else {
//        if (DEBUG) {
//          echo "ExecuteGeneralInfo error" . mysqli_error($con);
//        }
//        $err = "Product Inventory Information could not added";
//      }
    }
  }
}

$GetInventory = "SELECT * FROM product_inventories,products WHERE product_inventories.PI_id=$InventoryID AND product_inventories.PI_product_id=products.product_id";
$ExecuteInventory = mysqli_query($con, $GetInventory);
$SetInventory = mysqli_fetch_object($ExecuteInventory);


/* Start log */



$logArray = array();
$logArrayCounter = 0;
$logArrayQty = 0;
$logSql = "SELECT * FROM product_inventory_log  LEFT JOIN admins ON admins.admin_id=product_inventory_log.PIL_created_by WHERE PIL_PI_id= " . $SetInventory->PI_id . " ORDER BY PIL_created_date DESC";

$logSqlResult = mysqli_query($con, $logSql);
if ($logSqlResult) {
  $logArrayCounter = mysqli_num_rows($logSqlResult);
  while ($logSqlResultRowObj = mysqli_fetch_object($logSqlResult)) {
    $logArray[] = $logSqlResultRowObj;
    if ($logSqlResultRowObj->PIL_in_qty > 0) {
      $logArrayQty += $logSqlResultRowObj->PIL_in_qty;
    } else {
      $logArrayQty -= $logSqlResultRowObj->PIL_out_qty;
    }
  }
  mysqli_free_result($logSqlResult);
} else {

  if (DEBUG) {
    $err = "logSqlResult Error:  " . mysqli_error($con);
  } else {
    $err = "logSqlResult query Fail ";
  }
}


if (isset($SetInventory->PI_quantity) AND $SetInventory->PI_quantity > 0 AND $logArrayCounter == 0) {
  $initialSqlEntryField = "";
  $initialSqlEntryField .="PIL_PI_id= " . $SetInventory->PI_id;
  $initialSqlEntryField .=",PIL_date= '1970-00-00'";
  $initialSqlEntryField .=",PIL_in_qty= " . $SetInventory->PI_quantity;
  $initialSqlEntryField .=",PIL_note= 'Inserted existing quantity as initial value '";
  $initialSqlEntryField .=",PIL_created_by= 0";
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
//printDie($logArray);
/* End log */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin Panel |Edit  Product Inventory</title>

    <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Cuprum' rel='stylesheet' type='text/css' />
    <script src="<?php echo baseUrl('admin/js/jquery-1.4.4.js'); ?>" type="text/javascript"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload, editor -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/spinner/ui.spinner.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery-ui.min.js'); ?>"></script>  
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/fileManager/elfinder.min.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/jquery.wysiwyg.js'); ?>"></script>
    <!--Effect on wysiwyg editor -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.image.js'); ?>"></script>
    <!--Effect on wysiwyg editor -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.link.js'); ?>"></script>
    <!--Effect on wysiwyg editor -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/wysiwyg/wysiwyg.table.js'); ?>"></script>
    <!--Effect on wysiwyg editor -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/jquery.dataTables.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/dataTables/colResizable.min.js'); ?>"></script>
    <!--Effect on left error menu, top message menu -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/forms.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autogrowtextarea.js'); ?>"></script>
    <!--Effect on left error menu, top message menu, File upload -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/autotab.js'); ?>"></script>
    <!--Effect on left error menu, top message menu -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/forms/jquery.validationEngine.js'); ?>"></script>
    <!--Effect on left error menu, top message menu-->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/colorPicker/colorpicker.js'); ?>"></script>
    <!--Effect on left error menu, top message menu -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html5.js'); ?>"></script>
    <!--Effect on file upload-->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/plupload.html4.js'); ?>"></script>
    <!--No effect-->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/uploader/jquery.plupload.queue.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, File upload -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.tipsy.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,  -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jBreadCrumb.1.1.js'); ?>"></script>
    <!--Effect on left error menu, File upload -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/cal.min.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.collapsible.min.js'); ?>"></script>
    <!--Effect on left error menu, File upload -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.ToTop.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio, -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.listnav.js'); ?>"></script>
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/jquery.sourcerer.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/ui/jquery.jgrowl.js'); ?>"></script>
    <!--jquery.jgrowl.js:Black pop up message -->
    <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
    <script type="text/javascript" src="<?php echo baseUrl('admin/js/custom.js'); ?>"></script>
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


        <!-- Charts -->
        <div class="widget first">
          <div class="head">
            <h5 class="iGraph">Edit Inventory</h5></div>
          <div class="body">
            <div class="charts" style="width: 700px; height: auto;">
              <form action="edit_inventory.php?pid=<?php echo $_GET['pid']; ?>&inv_id=<?php echo $_GET['inv_id']; ?>" method="post" class="mainForm">

                <!-- Input text fields -->
                <fieldset>
                  <div class="widget first">
                    <div class="head"><h5 class="iList">Edit Inventory for <strong><?php echo $SetInventory->product_title; ?></strong></h5></div>

                    <div class="rowElem noborder">
                      <label>Bookmark List :</label>
                      <div class="formRight">
                        <select name="bookmark" >
                          <option value="0">Select Bookmark</option>
                          <?php echo $cat2DD->viewDropdown($config['BOOKMARK_CATEGORY_ID']); ?>
                        </select>
                      </div>

                    </div>
                    
                    <div class="rowElem noborder"><label>Inventory Title:</label><div class="formRight">
                        <input name="title" type="text" value="<?php echo $SetInventory->PI_inventory_title;
        ; ?>" />
                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Product Quantity:</label><div class="formRight onlyNums">
                        <input name="quan" type="text" id="quan" readonly value="<?php echo $SetInventory->PI_quantity; ?>" maxlength="20" style="width: 250px;" />
                        <input type="hidden" id="quanHidden" value="<?php echo $SetInventory->PI_quantity; ?>" maxlength="20" style="width: 250px;" />
                        <button id="in">+</button>&nbsp; <button id="out">-</button></div><div class="fix"></div></div>
                    <!--                                start in inventory -->
                    <div id="inFrom" style="<?php
                    if ($in_qty != '') {
                      echo 'display: block;';
                    } else {
                      echo 'display: none;';
                    }
                    ?>">
                      <div class="rowElem noborder"><label>In Quantity:</label><div class="formRight onlyNums">
                          <input name="in_qty" type="text" id="in_qty" autocomplete="off" value="<?php echo $in_qty; ?>" maxlength="20"/>
                        </div><div class="fix"></div></div>

                      <div class="rowElem noborder">
                        <label>In Date:</label>
                        <div class="formRight">
                          <input type="text" name="in_date" value="<?php echo $in_date; ?>" class="datepicker" />
                        </div>
                        <div class="fix"></div>
                      </div>

                      <div class="rowElem noborder"><label>In Remark:</label><div class="formRight">

                          <textarea name="in_note"><?php echo $in_note; ?></textarea>
                        </div><div class="fix"></div></div>
                    </div>
                    <!--                                end in inventory -->
                    <!--                                start out inventory -->
                    <div id="outFrom" style="<?php
                    if ($out_qty != '') {
                      echo 'display: block;';
                    } else {
                      echo 'display: none;';
                    }
                    ?>">
                      <div class="rowElem noborder"><label>Out Quantity:</label><div class="formRight onlyNums">
                          <input name="out_qty" type="text" id="out_qty" autocomplete="off" value="<?php echo $out_qty; ?>" maxlength="20"/>
                        </div><div class="fix"></div></div>

                      <div class="rowElem noborder"><label>Order No:</label><div class="formRight">
                          <input name="order_number" type="text" value="<?php echo $order_number; ?>" maxlength="20"/>
                        </div><div class="fix"></div></div>

                      <div class="rowElem noborder">
                        <label>Out Date:</label>
                        <div class="formRight">
                          <input type="text" name="out_date" value="<?php echo $out_date; ?>" class="datepicker" />
                        </div>
                        <div class="fix"></div>
                      </div>

                      <div class="rowElem noborder"><label>Out Remark:</label><div class="formRight">

                          <textarea name="out_note"><?php echo $out_note; ?></textarea>
                        </div><div class="fix"></div></div>
                    </div>
                    <!--                                end out inventory -->

                    <!--                                        Product color is not necessary for Bajaree. Using 0 as default-->  

                    <input type="hidden" value="0" name="color"></input>

                    <!--                                        <div class="rowElem noborder">
                                                                <label>Product Color :</label>
                                                                <div class="formRight">
                                                                    <select name="color"  onchange="getColorCodeOrImage(this.value)">
                                                                        <option value="0">Select Product Color</option>	
                    <?php
                    while ($rowcolor = mysqli_fetch_object($sqlcolor)) {
                      ?>
                                                                              <option value="<?php echo $rowcolor->color_id; ?>" <?php if ($SetInventory->PI_color_id == $rowcolor->color_id) echo 'selected="selected"'; ?> ><?php echo $rowcolor->color_title; ?></option>
                      <?php
                    }
                    ?>
                                                                    </select>&nbsp;&nbsp;&nbsp;&nbsp;<div id="shwClr" style="position:relative; left:170px; bottom:10px">Select a color.</div>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                </div>
                                                            </div>-->


                    <div class="rowElem noborder">
                      <label>Product Size :</label>
                      <div class="formRight">
                        <select name="size" >
                          <option value="0">Select Product Size</option>
                          <?php
                          $sqlsiz = mysqli_query($con, "SELECT * FROM product_sizes WHERE PS_product_id=" . intval($pid));
                          while ($rowsiz = mysqli_fetch_object($sqlsiz)) {
                            ?>
                            <option value="<?php echo $rowsiz->PS_size_id; ?>" <?php if ($SetInventory->PI_size_id == $rowsiz->PS_size_id) echo 'selected="selected"'; ?>><?php echo $rowsiz->PS_size_title; ?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>

                    </div>

                    <div class="rowElem noborder"><label>Product Cost:</label><div class="formRight">
                        <input name="cost" type="text" value="<?php echo $SetInventory->PI_cost; ?>" maxlength="20"/>
                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Product Old Price:</label><div class="formRight">
                        <input name="oldprice" type="text" value="<?php echo $SetInventory->PI_old_price; ?>" maxlength="20"/>
                      </div><div class="fix"></div></div>

                    <div class="rowElem noborder"><label>Product Current Price:</label><div class="formRight">
                        <input name="currentprice" type="text" value="<?php echo $SetInventory->PI_current_price; ?>" maxlength="20"/>
                      </div><div class="fix"></div></div>



                    <input type="submit" name="update" value="Update Inventory Details" class="greyishBtn submitForm" />
                    <div class="fix"></div>

                  </div>
                </fieldset>

              </form>		


            </div>
            <div class="stats">
              <ul>
                <li><a href="#" class="count grey" title=""><?php echo $logArrayCounter; ?></a><span>Total</span></li>
                <li><a href="#" class="count grey" title=""><?php echo $logArrayQty; ?></a><span>Quantity</span></li>

              </ul>
              <div class="fix"></div>
            </div>
            <div class="table">
              <div class="head">
                <h5 class="iFrames">Inventory Log </span></h5></div>
              <div id="deltag">       
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                  <thead>
                    <tr>

                      <th>No</th>
                      <th>Date</th>
                      <th>Qty</th>
                      <th>In/Out</th>
                      <th>Remark</th>
                      <th>Added By</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i = 0; $i < $logArrayCounter; $i++): ?>
                      <?php
                      $remark = '';
                      if ($logArray[$i]->PIL_order_number != '') {
                        $remark.= '<span>Order No: </span><strong>' . $logArray[$i]->PIL_order_number . '</strong>';
                      }

                      $remark .= '<p>' . $logArray[$i]->PIL_note . '</p>';
                      ?>
                      <?php
                      $type = 'Out';
                      if ($logArray[$i]->PIL_in_qty > 0) {
                        $type = 'In';
                      }
                      ?>
                      <tr class="gradeA">
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $logArray[$i]->PIL_date; ?></td>
                        <td><?php
                          if ($type == "Out") {
                            echo $logArray[$i]->PIL_out_qty;
                          } else {
                            echo $logArray[$i]->PIL_in_qty;
                          }
                          ?></td>
                        <td><?php echo $type; ?></td>
                        <td><?php echo $remark; ?></td>
                        <td class="center"><?php echo $logArray[$i]->admin_full_name; ?></td>
                      </tr>
<?php endfor; /* ($i;$i< $logArrayCounter;$i++) */ ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
    <!-- Content End -->

    <div class="fix"></div>
    </div>
    <script type="text/javascript">
      var quanVal = parseInt($("#quanHidden").val());
      $("#in").click(function() {
        $("#quan").val(quanVal);
        $("#outFrom input").val('');
        $("#outFrom textarea").val('');
        $("#outFrom").css('display', 'none');
        $("#inFrom").css('display', 'block');
        return false;
      });

      $("#out").click(function() {
        $("#quan").val(quanVal);
        $("#inFrom input").val('');
        $("#inFrom textarea").val('');
        $("#inFrom").css('display', 'none');
        $("#outFrom").css('display', 'block');
        return false;
      });
      /******************change quantity field with in and out quantity************************/
      $("#in_qty").live("keyup", function() {
        if ($("#in_qty").val() > 0) {
          var newQuanVal = quanVal + parseInt($("#in_qty").val());
          $("#quan").val(newQuanVal);
        } else {
          $("#quan").val(quanVal);
        }
      });
      $("#out_qty").live("keyup", function() {
        if ($("#out_qty").val() > 0) {

          if (quanVal >= parseInt($("#out_qty").val())) {
            var newQuanVal = quanVal - parseInt($("#out_qty").val());
            $("#quan").val(newQuanVal);
          } else {

            $("#quan").val(quanVal);
            $("#out_qty").val('');
            $.jGrowl('This quantity is not available');
          }
        } else {
          $("#quan").val(quanVal);
        }
      });
    </script>
<?php include basePath('admin/footer.php'); ?>