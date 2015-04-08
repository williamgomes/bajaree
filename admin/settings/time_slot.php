<?php
include ('../../config/config.php');
include basePath('lib/Zebra_Image.php');
if (!checkAdminLogin()) {
    $link = baseUrl('admin/index.php?err=' . base64_encode('Please login to access admin panel'));
    redirect($link);
}
//saving tags in database


$aid = getSession('admin_id'); //getting loggedin admin id

if (isset($_POST['update'])) {
  
  extract($_POST);
  $time1 = date('H:i:s',strtotime($END_TIME));
  $time2 = date('H:i:s',strtotime($START_TIME));
  $diff = $time1 - $time2;
  
  if($diff < 0){
    $err = "End Time must be greater than Start Time.";
  } else {
    $setupdate = mysqli_query($con, "UPDATE `config_settings` SET `CS_value` = CASE `CS_option`
                                                                                  WHEN 'START_TIME' THEN '$START_TIME'
                                                                                  WHEN 'END_TIME' THEN '$END_TIME'
                                                                                  WHEN 'TOTAL_SLOT' THEN '$TOTAL_SLOT'
                                                                                  ELSE `CS_value`
                                                                                  END");

    if ($setupdate) {
      $msg = "Delivery option updated successfully";
      //echo "<meta http-equiv='refresh' content='5; url=index.php'>";
    } else {
      $err = "Delivery option update failed";
    }
  }
}




$responses['START_TIME'] = get_option('START_TIME');
$responses['END_TIME'] = get_option('END_TIME');
$responses['TOTAL_SLOT'] = get_option('TOTAL_SLOT');


//echo $slot = $diff/$responses['TOTAL_SLOT'];
//$slot * 3600;

//echo abs(strtotime($responses['END_TIME']) - strtotime($responses['START_TIME'])/3600);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" href="<?php echo baseUrl('admin/images/favicon.ico') ?>" />
        <title>Admin Panel | Settings</title>

        <?php
        include basePath('admin/header.php');
        ?>
        <!--delete tags-->
        <script type="text/javascript">
          function calculateTimeDiff() {
            
            var startTime = $('#startTime').val();
            var endTime = $('#endTime').val();
            var totalSlot = $('#totalSlot').val();
            $.ajax({url: 'Ajax.SlotCal.php',
                data: {startTime: startTime, endTime: endTime, totalSlot: totalSlot}, //Modify this
                type: 'post',
                success: function(output) {
                  //alert(output);
                    var result = $.parseJSON(output);
                    if (result.error == 0) {
                      $('#newCalculation').html("<strong>New Difference between slots: " + result.timeDiff + "</strong>");
                    } else if (result.error > 0) {
                      alert(result.error_text);
                    }

                }
            });
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
            <?php include basePath('admin/settings/settings_left_navigation.php'); ?>

            <!-- Content Start -->
            <div class="content">
                <div class="title"><h5>Settings Module</h5></div>

                <!-- Notification messages -->
                <?php include basePath('admin/message.php'); ?>

                <!-- Charts -->
                <div class="widget first">
                    <div class="head">
                        <h5 class="iGraph">Website Settings</h5></div>
                    <div class="body">
                        <div class="charts" style="width: 700px; height: auto;">
                            <form action="time_slot.php" method="post" class="mainForm" enctype="multipart/form-data">

                                <!-- Input text fields -->
                                <fieldset>
                                    <div class="widget first">
                                        <div class="head"><h5 class="iList">Time Slot</h5></div>

                                        <div class="rowElem noborder">
                                          <label>Start Time:</label>
                                          <div class="formRight">
                                            <select name="START_TIME" id="startTime" onchange="calculateTimeDiff();">
                                              <option value="">Select Time</option>
                                              <?php
                                              $z = '';
                                              for ($x = 1; $x <= 12; $x++) {
                                              ?>
                                                <option value="<?php echo $x; ?>:00 AM" <?php if ($responses['START_TIME'] == $x . ':00 AM'){ echo 'selected'; } ?>><?php echo $x; ?>:00 AM</option>
                                                <!--<option value="<?php echo $x; ?>:30 AM" <?php if ($responses['START_TIME'] == $x . ':30 AM'){ echo 'selected'; } ?>><?php echo $x; ?>:30 AM</option>-->
                                              <?php }
                                              
//                                              for ($x = 1; $x <= 12; $x++) {
                                                ?>
                                                <!--<option value="<?php // echo $x; ?>:00 PM" <?php // if ($responses['START_TIME'] == $x . ':00 PM'){ echo 'selected'; } ?>><?php // echo $x; ?>:00 PM</option>-->
                                                <!--<option value="<?php // echo $x; ?>:30 PM" <?php // if ($responses['START_TIME'] == $x . ':30 PM'){ echo 'selected'; } ?>><?php // echo $x; ?>:30 PM</option>-->
                                              <?php
//                                                }
                                              ?>
                                            </select>
                                          </div>
                                          <div class="fix"></div>
                                        </div>
                                         
                                        
                                        <div class="rowElem noborder">
                                          <label>End Time:</label>
                                          <div class="formRight">
                                            <select name="END_TIME" id="endTime" onchange="calculateTimeDiff();">
                                              <option value="">Select Time</option>
                                              <?php
                                              $z = '';
//                                              for ($x = 1; $x <= 12; $x++) {
                                              ?>
                                                <!--<option value="<?php // echo $x; ?>:00 AM" <?php // if ($responses['END_TIME'] == $x . ':00 AM'){ echo 'selected'; } ?>><?php // echo $x; ?>:00 AM</option>-->
                                                <!--<option value="<?php // echo $x; ?>:30 AM" <?php // if ($responses['END_TIME'] == $x . ':30 AM'){ echo 'selected'; } ?>><?php // echo $x; ?>:30 AM</option>-->
                                              <?php // }
                                              
                                              for ($x = 1; $x <= 12; $x++) {
                                                ?>
                                                <option value="<?php echo $x; ?>:00 PM" <?php if ($responses['END_TIME'] == $x . ':00 PM'){ echo 'selected'; } ?>><?php echo $x; ?>:00 PM</option>
                                                <!--<option value="<?php echo $x; ?>:30 PM" <?php if ($responses['END_TIME'] == $x . ':30 PM'){ echo 'selected'; } ?>><?php echo $x; ?>:30 PM</option>-->
                                              <?php
                                                }
                                              ?>
                                            </select>
                                          </div>
                                          <div class="fix"></div>
                                        </div>
                                        
                                        
                                        <div class="rowElem noborder">
                                          <label>Total Slot:</label>
                                          <div class="formRight">
                                            <input id="totalSlot" name="TOTAL_SLOT" type="text" value="<?php echo ($responses['TOTAL_SLOT']); ?>" onkeyup="calculateTimeDiff();" style="width: 60px;float: left;"/>
                                            <div id="newCalculation" style="float: left; margin-left: 50px;">&nbsp;</div>
                                          </div>
                                          <div class="fix"></div>
                                        </div>
                                        
                                        <?php
                                        //finding out difference between start time and end time
                                        $time1 = date('H:i:s',strtotime($responses['END_TIME']));
                                        $time2 = date('H:i:s',strtotime($responses['START_TIME']));
                                        $diff = $time1 - $time2;

                                        //getting difference between each slot
                                        $slot = $diff/$responses['TOTAL_SLOT'];

                                        //converting decimal output into hour, minute & second
                                        $diffToTime = convertTime($slot);
                                        ?>  
                                        
                                        <div class="rowElem noborder"><label>Difference Between Slots:</label><div class="formRight"><strong><?php echo $diffToTime; ?></strong></div><div class="fix"></div></div>
                                        
                                        <input type="submit" name="update" value="Update Settings" class="greyishBtn submitForm" />
                                        <div class="fix"></div>

                                    </div>
                                </fieldset>

                            </form>		


                        </div>


                      <div class="table">
                    <div class="head"><h5 class="iFrames">Time Range List</h5></div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                        <thead>
                            <tr>
                                <th>TIme Range</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //converting time difference into seconds
                            $timeExpld = explode(':', $diffToTime);
                            $totalSec = ($timeExpld[0] * 3600) + ($timeExpld[1] * 60) + $timeExpld[2];
                            $rangeStartTime = date('H:i',strtotime($responses['START_TIME']));
                            ?>
                                <?php for ($i = 0; $i < $responses['TOTAL_SLOT']; $i++): ?>
                                <?php
                                //removing AM or PM from the string
                                //echo $rangeStartTime2 = str_replace(' AM','', str_replace(' PM','', $rangeStartTime));
                                //separating hours and minutes from each other
                                $strtTimeExp = explode(":", $rangeStartTime);
                                
                                $newTime = mktime($strtTimeExp[0], $strtTimeExp[1], 0 + $totalSec);
                                $rangeEndTime = date("H:i",$newTime);
                                ?>
                                    <tr class="center">
                                      <td class="center"><?php echo date("g:i A",strtotime($rangeStartTime)); ?> &rArr; <?php echo date("g:i A",strtotime($rangeEndTime)); ?></td>
                                    </tr>
                                <?php  
                                //assigning range end time as next slot start time
                                $rangeStartTime = $rangeEndTime;
                                endfor; /* $i=0; i<$adminArrayCounter; $++  */ ?>

                        </tbody>
                    </table>
                </div>


                      




                    </div>
                </div>

            </div>
            <!-- Content End -->

            <div class="fix"></div>
        </div>

        <?php include basePath('admin/footer.php'); ?>
