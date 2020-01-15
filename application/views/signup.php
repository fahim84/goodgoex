<!-- Modal // signup-->
<div class="modal fade home_model" id="signupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <img src="<?php echo base_url(); ?>assets/client/images/cross-icon.png" alt="cross-icon">
            </button>
            <form class="modal-body" method="post" action="<?php echo base_url(); ?>login/signup" enctype="multipart/form-data">
                <div class="modalheader">
                    <div class="modal_imageupload">
                        <input name="image" type="file" id="image" accept="image/*" class="filebrowse">
                        <div class="uploadedimgholder">
                            <img id="update_image" src="<?php echo base_url(); ?>assets/client/images/user-placeholder-icon.png" alt="user-placeholder-icon" class="modal_userimage" style="cursor: pointer;">
                        </div>
                        <a id="update_image_icon" href="#_" class="modal_userimagebtn">
                            <img  src="<?php echo base_url(); ?>assets/client/images/user-placeholder-edit-icon.png" alt="user-placeholder-edit-icon">
                        </a>
                    </div>
                    <h4>Upload Picture</h4>
                </div>
                <div class="row">
                    <input type="hidden" name="roles[]" value="3">
                    <div class="col-12">
                        <label>First Name</label>
                        <input name="firstname" type="text" class="form-control" placeholder="Enter user name" required>
                    </div>
                    <div class="col-12">
                        <label>Last Name</label>
                        <input name="lastname" type="text" class="form-control" placeholder="Enter last name" required>
                    </div>
                    <div class="col-12">
                        <label>Email</label>
                        <input name="email" type="email" class="form-control" placeholder="Enter email address" required>
                    </div>
                    <div class="col-12">
                        <label>Mobile Number (Optional)</label>
                        <input pattern="^\+?[1-9]\d{10,14}$" title="+971234567890" name="mobile" type="text" class="form-control" placeholder="+971234567890">
                    </div>
                    <div class="col-12">
                        <label>Password</label>
                        <input pattern=".{6,20}" title="Password must be 6 to 20 characters" name="password" type="password" class="form-control" placeholder="Enter password" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="modallogin">Signup</button>
                    </div>
                    <!--<div class="col-12 or_separator">
                        OR
                    </div>
                    <div class="col-12">
                        <button type="submit" class="socialbtn">
                            <img src="<?php /*echo base_url(); */?>assets/client/images/login-with-facebook.png">
                        </button>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="socialbtn">
                            <img src="<?php /*echo base_url(); */?>assets/client/images/login-with-googleplus.png">
                        </button>
                    </div>-->
                </div>

                    
            </form><!--//modal-body-->
        </div><!--//modal-content-->
    </div><!--//modal-dialog-->
</div><!--//modal//home_model//#signupModal-->

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