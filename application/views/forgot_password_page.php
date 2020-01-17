<?php $this->load->view('header',$this->data); ?>

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
                                <h3>Forgot Password</h3>
                            </div>

                            <form method="post" action="<?php echo base_url(); ?>login/forgot_password" class="row">
                                <div class="col-12">
                                    <label>Email</label>
                                    <input required name="email" type="email" class="form-control" placeholder="Enter user email">
                                </div>
                                <div class="col-md-12">
                                    <br>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </form>



                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Contact End /-->

<?php $this->load->view('footer',$this->data); ?>