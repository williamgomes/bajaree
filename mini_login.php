
<?php $login_email = ''; $login_pass = '';
if(isset($_COOKIE['a']) AND isset($_COOKIE['r'])){
  $login_email = base64_decode($_COOKIE['a']); 
  $login_pass = base64_decode($_COOKIE['r']);
}
?>
<!-- Modal -->
<div class="modal fade signUpContent" id="ModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="loginClose">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Login</h4>
            </div>
            <div class="modal-body-global">
                <div class="userForm">
                    <form name="signUp" method="post" action="#" autocomplete="off">
                        
                        <fieldset class="field-username">
                            <div class="control-group">
                              <input type="text" tabindex="1" size="32" required="required" placeholder="Email" name="user[username]" id="login_email" value="<?php echo $login_email; ?>">
                            </div>
                        </fieldset>
                        <fieldset class="field-password">
                            <div class="control-group">
                                <input type="password" tabindex="2" size="30" required="required" placeholder="Password" name="user[password]" id="login_password" value="<?php echo $login_pass; ?>">
                            </div>
                        </fieldset>
                        
                        <div class="checkbox" style="padding-left: 45px; margin-top: 5px; margin-bottom: 10px;">
                          <label>
                            <input type="checkbox" id="remember_me" <?php if(isset($_COOKIE['a']) AND isset($_COOKIE['r'])){ echo "checked"; } ?>> Remember Me
                          </label>
                        </div>
                        <div class="control-group">
                            <button class=" buttonGloabalFull" type="button" onClick="UserLogin();">Submit</button>
                        </div>
                    </form>
                    
                </div>
                <!--userForm--> 
                <div class="modal-footer">
                  <p class="pull-right">Not a member yet? <a data-toggle="modal" data-dismiss="modal" href="#ModalSignup">Join us!</a></p>
                  <p class="pull-left"><a href="<?php echo baseUrl(); ?>forgot-my-password">Forgot password?</a></p>
                </div>

            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>
<!-- /.modal -->

