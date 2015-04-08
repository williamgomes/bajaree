<?php
include ('../../config/config.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
$aid = getSession('admin_id');

//checking for activation id
if (isset($_GET['actid'])) {
    $ActID = $_GET['actid'];
    $sqlActivate = "UPDATE countries SET country_status='allow' WHERE country_id=$ActID";
    $executeActivate = mysqli_query($con, $sqlActivate);
}

//checking for deactivation id
if (isset($_GET['inactid'])) {
    $InactID = $_GET['inactid'];
    $sqlInactivate = "UPDATE countries SET country_status='notallow' WHERE country_id=$InactID";
    $executeInactivate = mysqli_query($con, $sqlInactivate);
}




//getting all country from table
$arrayCountry = array();
$sqlAllCountry = "SELECT * FROM countries";
$executeAllCountry = mysqli_query($con, $sqlAllCountry);
if ($executeAllCountry) {
    while ($getAllCountry = mysqli_fetch_object($executeAllCountry)) {
        $arrayCountry[] = $getAllCountry;
    }
} else {
    if (DEBUG) {
        echo "executeAllCountry error: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Country List</title>

        <?php include basePath('admin/header.php'); ?>


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
            <?php include ('country_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Country Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->



                <div class="table">
                    <div class="head">
                        <h5 class="iFrames">Country List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>Country ID</th>
                                <th>Country Name</th>
                                <th>Country Status</th>
                                <th>Country Updated By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $countryArrayCounter = count($arrayCountry);
                            if ($countryArrayCounter > 0):
                                ?>
                                <?php for ($i = 0; $i < $countryArrayCounter; $i++): ?>                        
                                    <tr class="gradeA">
                                        <td><?php echo $arrayCountry[$i]->country_id; ?></td>
                                        <td><?php echo $arrayCountry[$i]->country_name; ?></td>
                                        <td class="center">
                                            <?php if ($arrayCountry[$i]->country_status == 'allow') {
                                                echo '<a href="javascript:inactive(' . $arrayCountry[$i]->country_id . ');"><img src="' . baseUrl('admin/images/customButton/on.png') . '" width="60" /></a>';
                                            } else {
                                                echo '<a href="javascript:active(' . $arrayCountry[$i]->country_id . ');"><img src="' . baseUrl('admin/images/customButton/off.png') . '" width="60" /></a>';
                                            } ?>
                                        </td>
                                        <td><?php echo getFieldValue($tableNmae = 'admins', $fieldName = 'admin_full_name', $where = 'admin_id=' . $arrayCountry[$i]->country_updated_by); ?></td>
                                        <td class="center"><a href="edit_country.php?cid=<?php echo base64_encode($arrayCountry[$i]->country_id); ?>" title="Edit"><img src="<?php echo baseUrl('admin/images/pencil-grey-icon.png') ?>" height="14" width="14" alt="Edit" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<!--<a href="javascript:del(<?php echo $GetCountry['TC_id']; ?>);"><img src="../images/delete.png" /></a>--></td>
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
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "custom", {pattern: "XXXX000000"});
            var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency");
        </script>