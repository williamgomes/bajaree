<?php
include ('../../config/config.php');

$first_name = '';
$mid_name = '';
$last_name = '';
$email = '';
$userHash = '';

if (isset($_GET['user_id']) AND $_GET['user_id'] > 0) {
  $UserID = $_GET['user_id'];
  $sqlUserInfo = "SELECT * FROM users WHERE user_id=$UserID";
  $executeUserInfo = mysqli_query($con, $sqlUserInfo);
  if ($executeUserInfo) {
    $getUserInfo = mysqli_fetch_object($executeUserInfo);
    if (isset($getUserInfo->user_id)) {
      $firstName = $getUserInfo->user_first_name;
      $email = $getUserInfo->user_email;
      $userHash = $getUserInfo->user_hash;
    }
  }
  ?>
  <?php include('../header.php'); ?>

  <tr>
    <td bgcolor="#FFFFFF" style="display: block; max-width: 600px; margin: 0px auto; border-top: medium solid rgb(24, 128, 141);"><div style="display: block; margin: 0px auto; max-width: 650px; padding: 40px 60px 20px;">
        <p style="color:#434343;text-align:left;line-height:1.6;padding:0;font-weight:400;font-size:16px">Hi <?php echo $first_name . " " . $last_name; ?>,</p>
        <p style="color:#434343;text-align:left;line-height:1.6;padding:0;font-weight:400;font-size:16px">You signed up successfully in our website. Below is your details signup information:</p>
        <p style="color:#434343;text-align:left;line-height:1.6;padding:0;font-weight:400;font-size:16px"> 
          <strong>Name: </strong><?php echo $firstName; ?><br>
          <strong>Email: </strong><?php echo $email; ?><br>
        </p>

        <p style="color:#434343;text-align:left;line-height:1.6;padding:0;font-weight:400;font-size:16px"> 
          It is recommended to activate your account. Please click <b><a href="<?php echo baseUrl(); ?>verify-account?m=<?php echo base64_encode($email); ?>&t=<?php echo base64_encode($userHash); ?>&ac=<?php echo base64_encode('Verify'); ?>" target="blank">here</a></b> to activate your account.
        </p>

        <p style="color:#434343;text-align:left;line-height:1.6;padding:0;font-weight:400;font-size:16px"> 
          <strong>OR</strong>
        </p>

        <p style="color:#434343;text-align:left;line-height:1.6;padding:0;font-weight:400;font-size:16px"> 
          You can copy and paste below link in your browser:
          <br><br>
          <?php echo baseUrl(); ?>verify-account?m=<?php echo base64_encode($email); ?>&t=<?php echo base64_encode($userHash); ?>&ac=<?php echo base64_encode('Verify'); ?>
        </p>
        <p style="color:#434343;text-align:left;line-height:1.6;padding:0;font-weight:400;font-size:16px"> Thanks again!<span class="HOEnZb"><font color="#888888"><br>
           Bajaree.com Team </font></span></p>

  <!--        <p style="line-height: 1.6; color: rgb(119, 119, 119); font-weight: 400; padding: 20px 0px 0px; margin-top: 20px; border-top: 2px solid rgb(221, 221, 221); font-size: 11px;"> P.S. We hope you'll stay in touch! Check out <a target="_blank" style="color:#0D3D53" href="http://jita.com/blog">our blog</a>,
    or <a target="_blank" style="color:#0D3D53" href="http://twitter.com/wistia">facebook </a> to keep up 
    with our shenanigans. 
    </p>-->

        <p style="line-height: 1.6; color: rgb(119, 119, 119); font-weight: 400; padding: 20px 0px 0px; margin-top: 20px; border-top: 2px solid rgb(221, 221, 221); font-size: 11px;">
          Please add this email address to your safe list to ensure future messages are not sent to your spam folder. 
        </p>
      </div></td>
  </tr>

  <?php include('../footer.php'); ?>     


  <?php
} else {
  echo "Incorrect parameter";
}
?>
