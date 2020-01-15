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
                        <div class="col-md-7">
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
                            <form class="form-a" action="<?php echo base_url(); ?>login/signup" method="post" role="form" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <input name="image" type="file" id="image" accept="image/*" class="form-control form-control-lg form-control-a">
                                            <div class="validation"></div>

                                            <div class="uploadedimgholder">
                                                <img id="update_image" src="<?php echo base_url(); ?>uploads/images/placeholder.png" alt="user-placeholder-icon" class="modal_userimage" style="cursor: pointer;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <input name="firstname" type="text" class="form-control" placeholder="Enter First Name" required>
                                            <div class="validation"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <input name="lastname" type="text" class="form-control" placeholder="Enter Last Name" required>
                                            <div class="validation"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control form-control-lg form-control-a" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" required>
                                            <div class="validation"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <input pattern="^\+?[1-9]\d{10,14}$" title="+971234567890" name="mobile" type="text" class="form-control" placeholder="+971234567890">
                                            <div class="validation"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <input pattern=".{6,20}" title="Password must be 6 to 20 characters" name="password" type="password" class="form-control" placeholder="Enter password" required>
                                            <div class="validation"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-a">Signup</button>
                                    </div>
                                </div>

                                <input type="hidden" name="roles[]" value="3">
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Contact End /-->


    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#update_image').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function(){
            readURL(this);
            //alert('working');
        });

        $(document).on('click','#update_image, #update_image_icon',function () {
            $('#image').click();
        });
        $(document).on('change keydown', '#mobile', function(e){
            mobile = $('#mobile').val();

            // Allow: backspace, delete, tab, escape, enter and +
            console.log(e.keyCode);
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 107]) !== -1 ||
                // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });



    </script>
<?php $this->load->view('footer',$this->data); ?>