<?php $this->load->view('header',$this->data); ?>

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


    <div class="container-fluid innersection home_model">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="profiledit">
                        <form method="post" action="<?php echo base_url(); ?>welcome/profile" enctype="multipart/form-data">
                            <div class="modalheader">
                            <div class="modal_imageupload">
                                <input name="image" type="file" id="image" accept="image/*" class="filebrowse">
                                <div class="uploadedimgholder">
                                    <img id="update_image" src="<?php echo $update_data->image_url; ?>" alt="user-placeholder-icon" class="modal_userimage" style="cursor: pointer;">
                                </div>
                                <a id="update_image_icon" href="#_" class="modal_userimagebtn">
                                    <img src="<?php echo base_url(); ?>assets/client/images/user-placeholder-edit-icon.png" alt="user-placeholder-edit-icon">
                                </a>
                            </div>
                            <h4>Edit Picture</h4>
                        </div>

                            <div class="col-12">
                                <label>First Name</label>
                                <input name="firstname" value="<?php echo $update_data->firstname; ?>" type="text" class="form-control" placeholder="Enter user name" required>
                            </div>
                            <div class="col-12">
                                <label>Last Name</label>
                                <input name="lastname" value="<?php echo $update_data->lastname; ?>" type="text" class="form-control" placeholder="Enter last name" required>
                            </div>
                            <div class="col-12">
                                <label>Email</label>
                                <input name="email" value="<?php echo $update_data->email; ?>" type="email" class="form-control" placeholder="Enter email address" required readonly>
                            </div>
                            <div class="col-12">
                                <label>Mobile Number (Optional)</label>
                                <input pattern="^\+?[1-9]\d{10,14}$" value="<?php echo $update_data->mobile; ?>" title="+971234567890" name="mobile" type="text" class="form-control" placeholder="+971234567890">
                            </div>
                            <div class="col-12 inlinebuttonholder">
                                <button type="submit" class="btn btn_green inlinebtn">Save</button>
                                <a href="#" class="btn btn_red inlinebtn">Cancel</a>
                            </div>
                        </form>
                            <div class="col-12">
                                <form method="post" action="<?php echo base_url(); ?>welcome/profile" enctype="multipart/form-data">
                                    <fieldset class="row passwordborderedbox">
                                        <legend class="overlayheading">Change Password</legend>
                                        <div class="col-12">
                                            <label>Old Password</label>
                                            <input pattern=".{6,20}" title="Password must be 6 to 20 characters" name="old_password" type="password" class="form-control" placeholder="Enter password" required>
                                        </div>

                                        <div class="col-12">
                                            <label>New Password</label>
                                            <input pattern=".{6,20}" title="Password must be 6 to 20 characters" name="new_password" type="password" class="form-control" placeholder="Enter password" required>
                                        </div>
                                        <div class="col-12">
                                            <label>Confirm Password</label>
                                            <input pattern=".{6,20}" title="Password must be 6 to 20 characters" name="confirm_password" type="password" class="form-control" placeholder="Enter password" required>
                                        </div>
                                        <div class="col-12 inlinebuttonholder">
                                            <button type="submit" class="btn btn_green inlinebtn">Save</button>
                                            <a href="#" class="btn btn_red inlinebtn">Cancel</a>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>


                    </div><!--//col//-->
                </div><!--//row//-->
            </div><!--//container//-->
        </div><!--//row//-->
    </div>

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