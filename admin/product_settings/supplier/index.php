<?php
include ('../../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
//saving tags in database
$aid = @getSession('admin_id'); //getting admin id


//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE suppliers SET supplier_status='active' WHERE supplier_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
    $link = "index.php";
    redirect($link);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE suppliers SET supplier_status='inactive' WHERE supplier_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
    $link = "index.php";
    redirect($link);
}

$name = "";
$address = "";
$phone = "";
$partner = '';
$is_partner = 'no';

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
    $addSupplier = '';
    $addSupplier .= ' supplier_name = "' . mysqli_real_escape_string($con, $name) . '"';
    $addSupplier .= ', supplier_address = "' . mysqli_real_escape_string($con, $address) . '"';
    $addSupplier .= ', supplier_phone = "' . mysqli_real_escape_string($con, $phone) . '"';
    $addSupplier .= ', supplier_is_partner = "' . mysqli_real_escape_string($con, $is_partner) . '"';
    
    $sqlAddSupplier = "INSERT INTO suppliers SET $addSupplier";
    $executeAddSupplier = mysqli_query($con,$sqlAddSupplier);
    if($executeAddSupplier){
      $msg = 'Supplier added successfully';
    } else {
      if(DEBUG){
        $err = 'executeAddSupplier error: ' . mysqli_errno($con);
      } else {
        $err = 'executeAddSupplier query failed.';
      }
    }
  }
}



$arraySupplier = array();
$sqlGetSupplier = "SELECT * FROM suppliers";
$resultGetSupplier = mysqli_query($con, $sqlGetSupplier);
if($resultGetSupplier){
  while($resultGetSupplierObj = mysqli_fetch_object($resultGetSupplier)){
    $arraySupplier[] = $resultGetSupplierObj;
  }
} else {
  if(DEBUG){
     $err = "resultGetSupplier error: " . mysqli_errno($con);
  } else {
    $err = "resultGetSupplier query failed.";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Suppliers</title>

        <link href="<?php echo baseUrl('admin/css/main.css'); ?>" rel="stylesheet" type="text/css" /> 
        <script src="<?php echo baseUrl('admin/js/jquery.min.js'); ?>" type="text/javascript"></script>  
        <!--Start admin panel js/css --> 
        <?php include basePath('admin/header.php'); ?>   
        <!--End admin panel js/css -->    
        
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

        </script>
        <!--Deactivation Script -->


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
                <div class="title"><h5>Supplier Module</h5></div>

                <!-- Notification messages -->
<?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Supplier</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="index.php" method="post" class="mainForm" enctype="multipart/form-data" >

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
                                              <input name="partner" type="checkbox" value="yes"/>&nbsp;&nbsp;&nbsp;YES
                                            </div>
                                        </div>
                                        <div class="fix"></div>
                                        
                                      
                                        <input type="submit" name="submit" value="Add Supplier" class="greyishBtn submitForm" />
                                        <div class="fix"></div>


                                    </div>
                                </fieldset>

                            </form>		


                        </div>




                        <div class="table">
                            <div class="head">
                                <h5 class="iFrames">Supplier List</h5></div>
                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Is Partner?</th>
                                        <th>Status</th>
                                        <th>Area List</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
$countSupplier = count($arraySupplier);
if($countSupplier > 0):
  for($x = 0; $x < $countSupplier; $x++):
    ?>
                                  <tr class="gradeA">
                                            <td><?php echo $arraySupplier[$x]->supplier_name; ?></td>
                                            <td><?php echo $arraySupplier[$x]->supplier_phone; ?></td>
                                            <td><?php echo $arraySupplier[$x]->supplier_address; ?></td>
                                            <td><?php echo $arraySupplier[$x]->supplier_is_partner; ?></td>
                                            <td class="center">
                                              <?php
                                              if ($arraySupplier[$x]->supplier_status == 'active') {
                                                echo '<a href="javascript:inactive(' . $arraySupplier[$x]->supplier_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                              } else {
                                                echo '<a href="javascript:active(' . $arraySupplier[$x]->supplier_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                              }
                                              ?>
                                            </td>
                                            <td class="center"><a href="area_list.php?sid=<?php echo base64_encode($arraySupplier[$x]->supplier_id); ?>"><img src="<?php echo baseUrl('admin/images/icons/custom/expand.png') ?>" height="14" width="14" alt="Edit" /></a></td>
                                            <td class="center"><a href="edit.php?sid=<?php echo base64_encode($arraySupplier[$x]->supplier_id); ?>"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png');?>" height="14" width="14" /></a></td>
                                        </tr>
    <?php
  endfor;
endif;
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