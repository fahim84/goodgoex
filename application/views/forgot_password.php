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


<!-- Modal // forget password-->
<div class="modal fade home_model" id="forgotpasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <img src="<?php echo base_url(); ?>assets/client/images/cross-icon.png" alt="cross-icon">
            </button>
            <div class="modal-body">
                <div class="modalheader">
                    <img src="<?php echo base_url(); ?>assets/client/images/forgor-password-icon.png" alt="login_icon">
                    <h3>Forgot Password</h3>
                </div>
                <form method="post" action="<?php echo base_url(); ?>login/forgot_password" class="row">
                    <div class="col-12">
                        <label>Email</label>
                        <input required name="email" type="email" class="form-control" placeholder="Enter user email">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="modallogin">Send</button>
                    </div>
                </form><!--//form//col-->
            </div><!--//modal-body-->
        </div><!--//modal-content-->
    </div><!--//modal-dialog-->
</div><!--//modal//home_model//#forgotpasswordModal-->