<!--/ Nav Star /-->
<nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
                aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <a class="navbar-brand text-brand" href="<?php echo base_url(); ?>">Good<span class="color-b">GoEx</span></a>
        <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse"
                data-target="#navbarTogglerDemo01" aria-expanded="false">
            <span class="fa fa-search" aria-hidden="true"></span>
        </button>
        <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php echo @$active == 'home' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>welcome/index">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo @$active == 'about' ? 'active' : ''; ?>"  href="<?php echo base_url(); ?>welcome/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo @$active == 'contact' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>welcome/contact">Contact</a>
                </li>
                <?php if(isset($_SESSION['client']->user_id) ){ ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo @$active == 'logout' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>login/logout">Log Out</a>
                    </li>
                <?php }else{ ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo @$active == 'login' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>login/index">Login</a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo @$active == 'signup' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>login/signup">Sign Up</a>
                </li>
                <?php } ?>
            </ul>
        </div>

    </div>
</nav>
<!--/ Nav End /-->