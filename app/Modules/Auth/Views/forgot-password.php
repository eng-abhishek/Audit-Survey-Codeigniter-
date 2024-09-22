<?php echo view('Modules\Auth\Views\header_login'); ?>

 <body>
    <div class="login-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-col-img">

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="right-col-form">
                        <div class="logo">
                            <img src="<?php echo base_url('assets/login/images/logo.svg'); ?>" alt="">
                        </div>
                        <div class="login-form">
                            <h1>Send reset password link to your email</h1>
                             
                                <?php
                                if (isset($message)) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    echo $message;
                                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                } else if (session()->getFlashdata('message') !== NULL) {
                                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                    echo session()->getFlashdata('message');
                                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                }
                                ?>
                                 
                            
                            <?php if (session()->getFlashdata('error_message') !== NULL) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo session()->getFlashdata('error_message'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            <?php endif; ?>
                             <form action="<?php echo base_url('forgot-password'); ?>" class="forgotpasswordForm" id="forgotpasswordForm" method="post">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <?php
                                         $identity = [
                                            'name'  => 'identity',
                                            'id'    => 'identity',
                                            'class'  => 'form-control',
                                            'value' => set_value('identity'),
                                        ];
                                        echo form_input($identity);
                                    ?>
                                   
                                </div><br />
                                <div class="footer-links">
                                    <a href="<?php echo base_url('login'); ?>">Signin</a>

                                     <button type="submit" class="btn btn-success submitbutton">Send</button>
                                </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- /.login-box -->
<?php echo view('Modules\Auth\Views\footer_login'); ?>