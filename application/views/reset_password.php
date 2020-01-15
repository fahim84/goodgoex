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
                            <div class="col-12">
                                <form method="post" action="<?php echo base_url(); ?>login/reset_password">
                                    <fieldset class="row passwordborderedbox">
                                        <legend class="overlayheading">Reset Password</legend>

                                        <div class="col-12">
                                            <label>New Password</label>
                                            <input pattern=".{6,20}" title="Password must be 6 to 20 characters" name="password" type="password" class="form-control" placeholder="Enter password" required>
                                        </div>
                                        <div class="col-12">
                                            <label>Confirm Password</label>
                                            <input pattern=".{6,20}" title="Password must be 6 to 20 characters" name="confirm_password" type="password" class="form-control" placeholder="Enter password" required>
                                        </div>
                                        <div class="col-12 inlinebuttonholder">
                                            <button type="submit" class="btn btn_green inlinebtn">Save</button>
                                        </div>

                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                    </fieldset>
                                </form>
                            </div>


                    </div><!--//col//-->
                </div><!--//row//-->
            </div><!--//container//-->
        </div><!--//row//-->
    </div>

<?php $this->load->view('footer',$this->data); ?>