<?php
include ('../../config/config.php');

$aid = 0;
if (!checkAdminLogin()) {
  $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
  redirect($link);
} else {
  $aid = getSession('admin_id');
}


//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE users SET user_status='active' WHERE user_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
    if($executeActivate){
      $msg = "User status updated successfully.";
      $link = "index.php?msg=" . base64_encode($msg);
      redirect($link);
    }
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE users SET user_status='inactive' WHERE user_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
    if($executeInactivate){
      $msg = "User status updated successfully.";
      $link = "index.php?msg=" . base64_encode($msg);
      redirect($link);
    }
}


$totalCustomer = 0;
$totalVerifiedCustomer = 0;
$userPlacedOrder = 0;
$userID = 0;
$totalOrder = 0;
//getting customer list from database
$arrayUser = array();
$sqlGetUser = "SELECT * FROM users ORDER BY user_id DESC";
$resultGetUser = mysqli_query($con, $sqlGetUser);
if ($resultGetUser) {
  $totalCustomer = mysqli_num_rows($resultGetUser);
  while ($resultGetUserObj = mysqli_fetch_object($resultGetUser)) {
    $arrayUser[] = $resultGetUserObj;
    $userID = $resultGetUserObj->user_id;
    //counting verified users
    if($resultGetUserObj->user_verification == 'yes'){
      $totalVerifiedCustomer++;
    }
    
    //counting users who placed atleast one order
    $sqlCheckOrders = "SELECT order_id FROM orders WHERE order_user_id=$userID AND order_status='paid'";
    $resultCheckOrders = mysqli_query($con,$sqlCheckOrders);
    if($resultCheckOrders){
      $totalOrder = mysqli_num_rows($resultCheckOrders);
      if($totalOrder > 0){
        $userPlacedOrder++;
      }
    } else {
      if(DEBUG){
        echo "resultCheckOrders error: " . mysqli_error($con);
      }
    }
    
    
  }
} else {
  if (DEBUG) {
    echo "resultGetUser error: " . mysqli_error($con);
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
    <title>Admin Panel | Customer Activity</title>

    <?php include basePath('admin/header.php'); ?>

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
      <?php include ('customer_left_navigation.php'); ?>

      <!-- Content Start -->
      <div class="content">
        <div class="title"><h5>Customer Activity Module</h5></div>

        <!-- Notification messages -->
        <?php include basePath('admin/message.php'); ?>
        
        
        
        <div class="widget">
            <div class="head"><h5 class="iChart8">Customer statistic</h5><div class="num"></div></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
                <thead>
                    <tr>
                      <td align="center">Description</td>
                      <td width="21%">Amount</td>
                      <td width="21%">Status</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Customer</td>
                        <td align="center"><a href="#" title="" class="webStatsLink"><?php echo $totalCustomer; ?></a></td>
                        <td align="center">100%</td>
                    </tr>
                    <tr>
                        <td>Total Verified Customer</td>
                        <td align="center"><a href="#" title="" class="webStatsLink"><?php echo $totalVerifiedCustomer; ?></a></td>
                        <td align="center"><span><?php echo number_format((($totalVerifiedCustomer * 100) / $totalCustomer),1); ?>%</span></td>
                    </tr>
                    <tr>
                        <td>Customer With atleast 1 Complete Order</td>
                        <td align="center"><a href="#" title="" class="webStatsLink"><?php echo $userPlacedOrder; ?></a></td>
                        <td align="center"><span><?php echo number_format((($userPlacedOrder * 100) / $totalCustomer),1); ?>%</span></td>
                    </tr>
                </tbody>
            </table>                    
        </div>
        

        <!-- Charts -->



        <div class="table">
          <div class="head">
            <h5 class="iFrames">Customer List</h5></div>
          <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
              <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Last Login</th>
                <th>Email Verified?</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $countUserArray = count($arrayUser);
              if ($countUserArray > 0):
                for ($i = 0; $i < $countUserArray; $i++):
                  ?>
                  <tr class="gradeA">
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $arrayUser[$i]->user_first_name; ?></td>
                    <td><?php echo $arrayUser[$i]->user_email; ?></td>
                    <td><?php echo $arrayUser[$i]->user_phone; ?></td>
                    <td><?php echo date('d M Y h.i.s A', strtotime($arrayUser[$i]->user_last_login)); ?></td>
                    <td class="center">
                      <?php if ($arrayUser[$i]->user_verification == 'yes'): ?>
                        <img src="<?php echo baseUrl(); ?>images/tick.png" width="30"></img>
                      <?php else: ?>
                        <img src="<?php echo baseUrl(); ?>images/cross.png" width="30"></img>
                      <?php endif; //if($arrayUser[$i]->user_verification == 'yes'):?>
                    </td>
                    <td>
                      <?php
                      if ($arrayUser[$i]->user_status == 'active') {
                        echo '<a href="javascript:inactive(' . $arrayUser[$i]->user_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                      } else {
                        echo '<a href="javascript:active(' . $arrayUser[$i]->user_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                      }
                      ?>
                    </td>
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

    <div class="fix"></div>

    <?php include basePath('admin/footer.php'); ?>
    <script type="text/javascript">
      var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
      var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom", {pattern: "XXXX000000"});
      var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
      var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
    </script>
