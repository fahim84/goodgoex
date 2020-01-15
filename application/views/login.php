<!-- Modal // Login-->
<div class="modal fade home_model" id="loginModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <img src="<?php echo base_url(); ?>assets/client/images/cross-icon.png" alt="cross-icon">
            </button>
            <div class="modal-body">
                <div class="modalheader">
                    <img src="<?php echo base_url(); ?>assets/client/images/login-icon.png" alt="login_icon">
                    <h3>Login</h3>
                </div>
                <form method="post" action="<?php echo base_url(); ?>login/index" class="row">
                    <div class="col-12">
                        <label>Email</label>
                        <input required name="email" type="email" class="form-control" placeholder="Enter user email">
                    </div>
                    <div class="col-12">
                        <label>Password</label>
                        <input required name="password" type="password" class="form-control" placeholder="Enter password">
                    </div>
                    <div class="col-12">
                        <a href="javascript:void(0)" class="forgotpassword" aria-label="Close">Forgot password</a>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="modallogin">Login</button>
                    </div>

                    <div class="col-12 or_separator">
                        OR
                    </div>
                    <div class="col-12">
                        <a onclick="checkLoginState();" class="socialbtn">
                            <img src="<?php echo base_url(); ?>assets/client/images/login-with-facebook.png">
                        </a>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="socialbtn">
                            <img src="<?php echo base_url(); ?>assets/client/images/login-with-googleplus.png">
                        </button>
                    </div>
                </form><!--//form//col-->
                <p class="modal_noaccount">Don't have an account ? <a href="javascript:void(0)" class="signupfromlogin" data-dismiss="modal" aria-label="Close" >Sign up here</a></p>
            </div><!--//modal-body-->
        </div><!--//modal-content-->
    </div><!--//modal-dialog-->
</div><!--//modal//home_model//#loginModal-->