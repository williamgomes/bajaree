<?php
include 'config/config.php';
include ('./lib/email/mail_helper_functions.php');

$CartID = '';
$loginEmail = '';
$loginPass = '';
$email = '';
$pass = '';
$fname = '';
$checkout = '';
$phone_last = '';
$phone_first = '';
$phone = '';

$page_title = get_option('SITE_DEFAULT_META_TITLE');
$page_description = get_option('SITE_DEFAULT_META_DESCRIPTION');
$page_keywords = get_option('SITE_DEFAULT_META_KEYWORDS');
$site_author = $config['CONFIG_SETTINGS']['SITE_AUTHOR'];

//checking if user logged in and if he got redirected from checkout
if (checkUserLogin()) {
  if (isset($_GET['checkout']) AND $_GET['checkout'] == 'true') {
    $link = baseUrl() . 'checkout-step-1?msg=' . base64_encode('Process was successfull.');
    redirect($link);
  } else {
    $link = baseUrl() . 'my-account?msg=' . base64_encode('Process was successfull.');
    redirect($link);
  }
}

if (isset($_GET['checkout'])) {
  $checkout = $_GET['checkout'];
}


//signing up user
if (isset($_POST['register'])) {

  extract($_POST);

  if ($email == '') {
    $err = "Email Address is required.";
  } elseif ($pass == '') {
    $err = "Password is required.";
  } elseif ($fname == '') {
    $err = "Name is required.";
  } elseif ($phone_last == '') {
    $err = "Mobile Number is required.";
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $err = "Please provide a valid Email Address."; // Incorrect email address format
    } else {
      $emailCount = 0;
      $sqlCheck = "SELECT * FROM users WHERE user_email='" . mysqli_real_escape_string($con, $email) . "'";
      $executeCheck = mysqli_query($con, $sqlCheck);
      if ($executeCheck) {
        $emailCount = mysqli_num_rows($executeCheck);
        if ($emailCount > 0) {
          $err = "This Email already exist."; // Email address already registered with database
        } else {

          $securePass = securedPass($pass);
          $userHash = session_id();
          $phone = $phone_first . '' . $phone_last;

          $AddUser = '';
          $AddUser .= ' user_email = "' . mysqli_real_escape_string($con, $email) . '"';
          $AddUser .= ', user_password = "' . mysqli_real_escape_string($con, $securePass) . '"';
          $AddUser .= ', user_first_name = "' . mysqli_real_escape_string($con, $fname) . '"';
          $AddUser .= ', user_phone = "' . mysqli_real_escape_string($con, $phone) . '"';
          $AddUser .= ', user_hash = "' . mysqli_real_escape_string($con, $userHash) . '"';

          $sqlAddUser = "INSERT INTO users SET $AddUser";
          $executeAddUser = mysqli_query($con, $sqlAddUser);
          if ($executeAddUser) {
            //setting up user session values
            $userID = mysqli_insert_id($con);
            setSession('FirstName', $fname);
            setSession('UserID', $userID);
            setSession('Email', $email);
            setSession('IsEmailVerified', "no");

            //sending email to user
            $Subject = "Registration confirmation from bajaree.com";
            $EmailBody = file_get_contents(baseUrl('emails/signup/signup.body.php?user_id=' . $userID));
            $sendEmailToApplicant = sendEmailFunction($email, $fname, 'no-reply@bajaree.com', $Subject, $EmailBody);


            if ($sendEmailToApplicant) {

              //checking if user already added product to cart
              $countTempCartProduct = 0;
              $sqlTempCart = "SELECT * FROM temp_carts WHERE TC_session_id='$CartID'";
              $executeTempCart = mysqli_query($con, $sqlTempCart);
              if ($executeTempCart) {
                $countTempCartProduct = mysqli_num_rows($executeTempCart);
                if ($countTempCartProduct > 0) {
                  //updating userid into temp cart
                  $updateCart = '';
                  $updateCart .= ' TC_user_id = "' . intval($userID) . '"';

                  $sqlUpdateCart = "UPDATE temp_carts SET $updateCart WHERE TC_session_id='$CartID'";
                  $executeUpdateCart = mysqli_query($con, $sqlUpdateCart);
                  if (!$executeUpdateCart) {
                    if (DEBUG) {
                      $err = "executeUpdateCart error: " . mysqli_error($con); // Incorrect email address format
                    } else {
                      $err = "executeUpdateCart query failed"; // Incorrect email address format
                    }
                  }
                }
              } else {
                if (DEBUG) {
                  $err = "executeTempCart error: " . mysqli_error($con); // Incorrect email address format
                } else {
                  $err = "executeTempCart query failed"; // Incorrect email address format
                }
              }
            } else {
              $err = "Email send failed"; // Incorrect email address format
            }

            // User signed in successfully
            if (isset($_GET['checkout']) AND $_GET['checkout'] == 'true') {
              $link = baseUrl() . 'checkout-step-1?msg=' . base64_encode('Signup process was successfull. Please check your inbox.');
              redirect($link);
            } else {
              $link = baseUrl() . 'my-account?msg=' . base64_encode('Signup process was successfull. Please check your inbox.');
              redirect($link);
            }
          } else {
            if (DEBUG) {
              $err = "executeAddUser error: " . mysqli_error($con); // $executeAddUser failed
            } else {
              $err = "executeAddUser query failed."; // $executeAddUser failed
            }
          }
        }
      } else {
        if (DEBUG) {
          $err = "executeCheck error: " . mysqli_error($con); // $executeCheck query failed
        } else {
          $err = "executeCheck query failed."; // $executeCheck query failed
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $page_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description; ?>">
    <meta name="keywords" content="<?php echo $page_keywords; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">

    <?php include basePath('header_script.php'); ?>

  </head>

  <body>
    <div id="wrapper">


      <div id="wrapper">
        <div id="header">
          <div class="navbar navbar-default navbar-fixed-top megamenu">
            <div class="container-full">
              <?php include basePath('headertop.php'); ?>
              <!--/.headertop -->
              <?php include basePath('header_mid.php'); ?>
              <!--/.headerBar -->

              <?php include basePath('header_menu.php'); ?>
              <!--/.menubar --> 
            </div>
          </div>

        </div>
        <!-- header end -->

        <div class="w100 mainContainer nopaddb">


          <div class="container nopaddb">

            <div class="row">
              <?php include basePath('alert.php'); ?>
            </div>

            <div id="content"> 
              <div class="login-content">
                <div class="row">
                  <div class="container signUpcontainer signUpcontainerBg">
                    <h3 class="text-center">Account Sign Up</h3>
                    <div class="userContent">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-lg-12">
                        <div class="signupReason">
                          <ul class="rslides">
                            <li><img class="img-responsive" src="images/reason1.png" alt="reason"></li>
                            <li><img class="img-responsive" src="images/reason2.png" alt="reason"></li>
                            <li><img class="img-responsive" src="images/reason3.png" alt="reason"></li>
                          </ul>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-lg-12 NewuserForm">
                        <div class="NewuserFormBox">
                          <form enctype="multipart/form-data" method="post" action="<?php echo baseUrl(); ?>user-signin-signup?<?php
                          if ($checkout != '') {
                            echo 'checkout=' . $checkout;
                          }
                          ?>" autocomplete="off">
                            <div class="form-group">
                              <input type="text" required value="<?php echo $fname; ?>" name="fname" class="form-control" id="exampleInputEmail1" placeholder="Name">
                            </div>
                            <div class="control-group inpitgroup-sg">
                              <div class="cinn "> <label class="control-label clvl hide" for="selectbasic">+88</label>
                                <div class="indgsj"> 
                                  <select id="signup_selectbasic" name="phone_first" class=" form-control slct" tabindex="2">
                                    <option value="+8802" selected>+8802</option>
                                    <option value="+88011">+88011</option>
                                    <option value="+88015">+88015</option>
                                    <option value="+88016">+88016</option>
                                    <option value="+88017">+88017</option>
                                    <option value="+88018">+88018</option>
                                    <option value="+88019">+88019</option>
                                  </select>
                                  <input type="text" name="phone_last" class="form-control inpt" placeholder="Mobile Number" maxlength="8" id="signup_phone" tabindex="3" value="<?php echo $phone_last; ?>" required></div>

                              </div>
                            </div>
                            <div class="form-group">
                              <input type="email" required value="<?php echo $email; ?>" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                            </div>

                            <div class="form-group">
                              <input type="password" required value="<?php echo $pass; ?>" name="pass" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>

                            <button type="submit" name="register" class="btn btn-default btn-primary">Submit</button>
                          </form>
                        </div>

                      </div>
                    </div>
                    <div style="clear:both;"></div>
                    <p class="text-center clearfix lonInLink">Already a member? <a href="#ModalLogin" data-toggle="modal" data-target="#ModalLogin">Log In here</a></p>
                  </div>	

                </div>	

              </div>
            </div>

          </div>



          <!--brandFeatured-->

        </div>
        <!-- Main hero unit -->

      <?php include basePath('footer.php'); ?>

      </div>
      <?php include basePath('mini_login.php'); ?>
      <?php include basePath('mini_signup.php'); ?>
      <?php include basePath('mini_cart.php'); ?>

<?php include basePath('footer_script.php'); ?>
      <script type='text/javascript' src="js/responsiveslides.min.js"></script>
      <script>
        $(function() {
          $(".rslides").responsiveSlides();
        });
      </script>

  </body>
</html>
