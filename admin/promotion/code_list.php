<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}


//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE promotion_codes SET PC_code_status='active' WHERE PC_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
    $link = "code_list.php?pid=" . $_GET['pid'];
    redirect($link);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE promotion_codes SET PC_code_status='inactive' WHERE PC_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
    $link = "code_list.php?pid=" . $_GET['pid'];
    redirect($link);
}


//getting promotion code id from URL
if (isset($_GET['pid']) AND $_GET['pid'] != '') {
    $PromotionID = base64_decode($_GET['pid']);
}



$arrayPromotionCode = array();
$sqlPromotionCode = "SELECT * FROM promotion_codes WHERE PC_promotion_id=$PromotionID";
$executePromotionCode = mysqli_query($con, $sqlPromotionCode);
if ($executePromotionCode) {
    while ($getPromotionCode = mysqli_fetch_object($executePromotionCode)) {
        $arrayPromotionCode[] = $getPromotionCode;
    }
} else {
    if (DEBUG) {
        echo 'executePromotionCode error: ' . mysqli_error($con);
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin panel | Promotion list</title>

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
                        window.location.href = 'code_list.php?<?php echo $_SERVER['QUERY_STRING']; ?>&actid=' + pin_id;
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
                        window.location.href = 'code_list.php?<?php echo $_SERVER['QUERY_STRING']; ?>&inactid=' + pin_id;
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
            <?php include 'promotion_left_navigation.php'; ?>

            <!-- Content Start -->
            <div class="content">




                <div class="title"><h5> Promotion Module </h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>
                <!-- Charts -->
                <div class="table">
                    <div class="head"><h5 class="iFrames">Promotion Code List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Code Prefix</th>
                                <th>Code Suffix</th>
                                <th>Defined Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $countArrayPromotionCode = count($arrayPromotionCode);
                            if ($countArrayPromotionCode > 0):
                                ?>
                                <?php for ($i = 0; $i < $countArrayPromotionCode; $i++): ?>
                                    <tr class="gradeA">
                                        <td><?php echo $arrayPromotionCode[$i]->PC_code_prefix; ?></td>
                                        <td><?php echo $arrayPromotionCode[$i]->PC_code_suffix; ?></td>
                                        <td><?php echo $arrayPromotionCode[$i]->PC_code_used_email; ?></td>
                                        <td class="center">
                                            <?php if ($arrayPromotionCode[$i]->PC_code_status == 'active') {
                                                echo '<a href="javascript:inactive(' . $arrayPromotionCode[$i]->PC_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                            } else {
                                                echo '<a href="javascript:active(' . $arrayPromotionCode[$i]->PC_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                            } ?>
                                        </td>
                                        <td class="center">

                                            <a href="code_edit.php?cid=<?php echo base64_encode($arrayPromotionCode[$i]->PC_id); ?>&pid=<?php echo $_GET['pid']; ?>"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png') ?>" height="14" width="14" alt="Edit" /></a>

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
