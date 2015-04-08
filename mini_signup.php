<div class="modal fade signUpContent" id="ModalSignup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="signupClose">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Sign Up</h4>
            </div>
            <div class="modal-body-global">
                <div class="userForm">
                    <form name="signUp" method="post" action="#" autocomplete="off">
<!--                        <div class="control-group"> <a class="fb_button " href="#"> SIGNUP WITH FACEBOOK </a> </div>-->
<!--                        <h5 style="padding:10px 0 0 0;" align="center"> OR</h5>-->

                        <div class="success hide text-center padding-bottom-10" id="success">Success ! </div>
                        <div class="warning hidden text-center padding-bottom-10" id="error"> Error ! </div>
                        
                        <fieldset class="field-username">
                            <div class="control-group">
                                <input type="text" tabindex="1" required="required" placeholder="Name" name="user[username]" maxlength="32" id="signup_user_first_name" data-validation-attr="username" class="duplicate-check-js">
                            </div>
                        </fieldset>
                        <div class="control-group inpitgroup-sg">
                          <div class="cinn "> <label class="control-label clvl hide" for="selectbasic">+88</label>
                            <div class="indgsj"> 
                              <select id="signup_selectbasic" name="selectbasic" class=" form-control slct" tabindex="2">
                                <option value="+8802" selected>+8802</option>
                                <option value="+88011">+88011</option>
                                <option value="+88015">+88015</option>
                                <option value="+88016">+88016</option>
                                <option value="+88017">+88017</option>
                                <option value="+88018">+88018</option>
                                <option value="+88019">+88019</option>
                              </select>
                              <input type="text" class="form-control inpt" placeholder="Mobile Number" maxlength="8" id="signup_phone" tabindex="3"></div>

                          </div>
                        </div>
                        <div class="control-group">
                            <input type="text" tabindex="4" required="required" placeholder="Email" name="email[email]" maxlength="32" id="signup_email" data-validation-attr="email" class="duplicate-check-js">
                        </div>
                        <fieldset class="field-password">
                            <div class="control-group">
                                <input type="password" tabindex="5" required="required" placeholder="Password" name="user[password]" id="signup_password">
                            </div>
                        </fieldset>
                        
                        <div class="control-group">
                            <button class="buttonGloabalFull" type="button" onClick="UserSignup();" id="signupSumit"> Submit </button>
                        </div>
                    </form>
                    <p align="center">Already a member? <a data-toggle="modal"  data-dismiss="modal" href="#ModalLogin">Login </a></p>
                </div>
                <!--userForm--> 

            </div>
        </div>
        <!-- /.modal-content --> 
    </div>
    <!-- /.modal-dialog --> 
</div>