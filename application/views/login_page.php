<?php $this->load->view('header',$this->data); ?>

    <script>

        window.fbAsyncInit = function() {
            FB.init({
                appId      : '898458613877279',
                cookie     : true,  // enable cookies to allow the server to access
                                    // the session
                xfbml      : true,  // parse social plugins on this page
                version    : 'v3.2' // The Graph API version to use for the call
            });

            // Now that we've initialized the JavaScript SDK, we call
            // FB.getLoginStatus().  This function gets the state of the
            // person visiting this page and can return one of three states to
            // the callback you provide.  They can be:
            //
            // 1. Logged into your app ('connected')
            // 2. Logged into Facebook, but not your app ('not_authorized')
            // 3. Not logged into Facebook and can't tell if they are logged into
            //    your app or not.
            //
            // These three cases are handled in the callback function.

            FB.getLoginStatus(function(response) {

            });

        };

        // Load the SDK asynchronously
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function login_by_facebook()
        {
            FB.login(function(response) {
                console.log(response);
                if (response.status === 'connected') {
                    console.log(response.authResponse.accessToken);
                    fb_login_info();
                } else {
                    // The person is not logged into this app or we are unable to tell.
                }
            }, {scope: 'public_profile,email'});
        }

        function fb_login_info() {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me?fields=name,email,first_name,last_name,middle_name,picture', function(response) {
                console.log('Successful login for: ' + response.name);
                console.log(response);

                $.ajax({
                    url: "<?php echo base_url(); ?>login/login_by_facebook",
                    type:'POST',
                    dataType: 'json',
                    data: {'facebook_id':response.id,
                        'email':response.email,
                        'first_name':response.first_name,
                        'last_name':response.last_name,
                        'name':name
                    }
                }).done(function (data){
                    if(data.success)
                    {
                        window.location.reload();
                    }
                });

            });
        }
    </script>

    <!--/ Contact Star /-->
    <section class="contact">
        <div class="container">
            <div class="row">

                <div class="col-sm-12 section-t8">
                    <div class="row">
                        <div class="offset-md-3 col-md-6">
                            <?php if (validation_errors()): ?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo validation_errors();?>
                                </div>
                            <?php endif; ?>

                            <?php if(isset($_SESSION['msg_error'])){ ?>
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo display_error(); ?>
                                </div>
                            <?php } ?>

                            <?php if(isset($_SESSION['msg_success'])){ ?>
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo display_success_message(); ?>
                                </div>
                            <?php } ?>

                            <div class="modalheader">
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
                                <div class="col-md-12">
                                    <br>
                                </div>
                                <div class="col-12">

                                    <a href="<?php echo base_url(); ?>login/forgot_password" class="forgotpassword pull-right">Forgot password</a>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>

                                <div class="col-12 or_separator" align="center">
                                    OR
                                </div>
                                <div class="col-md-12">
                                    <br>
                                </div>

                            </form><!--//form//col-->


                            <p class="modal_noaccount">Don't have an account ? <a href="<?php echo base_url(); ?>login/signup" class="signupfromlogin" >Sign up here</a></p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Contact End /-->

<?php $this->load->view('footer',$this->data); ?>