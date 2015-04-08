<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
//saving tags in database
$aid = @getSession('admin_id'); //getting admin id

$supplierID = 0; 
if(isset($_GET['sid']) AND $_GET['sid'] != ''){
  $supplierID = base64_decode($_GET['sid']); //getting color id from url
}


$name = "";
$address = "";
$phone = "";
$partner = '';
$is_partner = 'no';
$status = '';

$sqlGetSupplier = "SELECT * FROM suppliers WHERE supplier_id=$supplierID";
$resultGetSupplier = mysqli_query($con, $sqlGetSupplier);
if($resultGetSupplier){
  while($resultGetSupplierObj = mysqli_fetch_object($resultGetSupplier)){
    $name = $resultGetSupplierObj->supplier_name;
    $address = $resultGetSupplierObj->supplier_address;
    $phone = $resultGetSupplierObj->supplier_phone;
    $partner = $resultGetSupplierObj->supplier_is_partner;
    $status = $resultGetSupplierObj->supplier_status;
  }
} else {
  if(DEBUG){
     $err = "resultGetSupplier error: " . mysqli_errno($con);
  } else {
    $err = "resultGetSupplier query failed.";
  }
}



if (isset($_POST['submit'])) {
  
  extract($_POST);
  
  if(isset($_POST['partner']) AND $_POST['partner'] == 'yes'){
    $is_partner = 'yes';
  }

  if ($name == '') {
    $err = "Name is required.";
  } elseif ($phone == "") {
    $err = "Phone is required.";
  } else {
    $updateSupplier = '';
    $updateSupplier .= ' supplier_name = "' . mysqli_real_escape_string($con, $name) . '"';
    $updateSupplier .= ', supplier_address = "' . mysqli_real_escape_string($con, $address) . '"';
    $updateSupplier .= ', supplier_phone = "' . mysqli_real_escape_string($con, $phone) . '"';
    $updateSupplier .= ', supplier_is_partner = "' . mysqli_real_escape_string($con, $is_partner) . '"';
    
    $sqlUpdateSupplier = "UPDATE suppliers SET $updateSupplier WHERE supplier_id=$supplierID";
    $executeUpdateSupplier = mysqli_query($con,$sqlUpdateSupplier);
    if($executeUpdateSupplier){
      $msg = 'Supplier updated successfully';
      $link = 'index.php?msg=' . base64_encode($msg);
      redirect($link);
    } else {
      if(DEBUG){
        $err = 'executeUpdateSupplier error: ' . mysqli_error($con);
      } else {
        $err = 'executeUpdateSupplier query failed.';
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
        <title>Admin Panel | Color</title>

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
        <!--Effect on left error menu, top message menu,Drowpdowns and selects, Checkbox and radio -->
        <script type="text/javascript" src="<?php echo baseUrl('admin/js/custom.js'); ?>"></script>
        <!--Effect on left error menu, top message menu, body-->
        <!--delete tags-->
        <script type="text/javascript">
            function del(pin_id1)
            {
                if (confirm('Are you sure to delete this size!!'))
                {
                    window.location = 'index.php?del=' + pin_id1;
                }
            }
        </script>
        <!--end delete tags-->


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
                <div class="title"><h5>Color Module</h5></div>

                <!-- Notification messages -->
        <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Color</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="edit.php?sid=<?php echo $_GET['sid']; ?>" method="post" class="mainForm" enctype="multipart/form-data" >

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Add Supplier</h5></div>
                                        <div class="rowElem noborder">
                                            <label>Name:</label>
                                            <div class="formRight">
                                                <input name="name" type="text" value="<?php echo $name; ?>"/>
                                            </div>
                                        </div>
                                        <div class="fix"></div>
                                        
                                        <div class="rowElem noborder">
                                            <label>Address:</label>
                                            <div class="formRight">
                                                <input name="address" type="text" value="<?php echo $address; ?>"/>
                                            </div>
                                        </div>
                                        <div class="fix"></div>
                                        
                                        <div class="rowElem noborder">
                                            <label>Phone:</label>
                                            <div class="formRight">
                                                <input name="phone" type="text" value="<?php echo $phone; ?>"/>
                                            </div>
                                        </div>
                                        <div class="fix"></div>
                                        
                                        <div class="rowElem noborder">
                                            <label>Is Partner?:</label>
                                            <div class="formRight">
                                              <input name="partner" type="checkbox" value="yes" <?php if($partner == 'yes'){ echo 'checked'; } ?>/>&nbsp;&nbsp;&nbsp;YES
                                            </div>
                                        </div>
                                        <div class="fix"></div>
                                        
                                      
                                        <input type="submit" name="submit" value="update Supplier" class="greyishBtn submitForm" />
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