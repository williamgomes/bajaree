<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}

//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE admins SET admin_status='active' WHERE admin_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE admins SET admin_status='inactive' WHERE admin_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
}


$adminArray = array();
$adminSql = "SELECT * FROM admins";
$adminSqlResult = mysqli_query($con, $adminSql);
if ($adminSqlResult) {
    while ($adminSqlResultRowObj = mysqli_fetch_object($adminSqlResult)) {
        $adminArray[] = $adminSqlResultRowObj;
    }
    mysqli_free_result($adminSqlResult);
} else {
    if (DEBUG) {
        echo 'adminSqlResult Error : ' . mysqli_errno($con);
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Admin Panel | Admin List</title>   
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
            <?php include 'admin_left_navigation.php'; ?>

            <!-- Content Start -->
            <div class="content">




                <div class="title"><h5> Admin Module </h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="table">
                    <div class="head"><h5 class="iFrames">Admin List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $adminArrayCounter = count($adminArray);
                            if ($adminArrayCounter > 0):
                                ?>
                                <?php for ($i = 0; $i < $adminArrayCounter; $i++): ?>
                                    <tr class="gradeA">
                                        <td><?php echo $adminArray[$i]->admin_email; ?></td>
                                        <td><?php echo $adminArray[$i]->admin_full_name; ?></td>
                                        <td><?php echo $adminArray[$i]->admin_type; ?></td>
                                        <td class="center">
                                            <?php if ($adminArray[$i]->admin_status == 'active') {
                                                echo '<a href="javascript:inactive(' . $adminArray[$i]->admin_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                            } else {
                                                echo '<a href="javascript:active(' . $adminArray[$i]->admin_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                            } ?>
                                        </td>
                                        <td class="center">
                                            <?php if (checkAdminAccess('admin/admin/admin_edit.php')): ?>
                                                <a href="admin_edit.php?id=<?php echo base64_encode($adminArray[$i]->admin_id); ?>"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png'); ?>" height="14" width="14" alt="Edit" /></a>

        <?php else: /* checkAdminAccess('admin/admin/admin_edit.php') */ ?>
                                                &nbsp;
        <?php endif; /* checkAdminAccess('admin/admin/admin_edit.php') */ ?>



                                        </td>
                                    </tr>
    <?php endfor; /* $i=0; i<$adminArrayCounter; $++  */ ?>
<?php endif; /* count($adminArray) > 0 */ ?>


                        </tbody>
                    </table>
                </div>

            </div>


            <!-- Content End -->

            <div class="fix"></div>
        </div>

<?php include basePath('admin/footer.php'); ?>
