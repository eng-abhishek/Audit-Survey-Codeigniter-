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
                            <h1>Sign in to start your session</h1>
                                    <?php 
                                    if ($message != '') {
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                                        echo $message; 
                                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                    }
                                    ?>
                                    <?php
                                    if (session()->getFlashdata('message') !== NULL) :
                                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.session()->getFlashdata('message').'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                                    endif;
                                    ?>
                            
                            <?php if (session()->getFlashdata('error_message') !== NULL) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo session()->getFlashdata('error_message'); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            <?php endif; ?>
                             <?php echo form_open(base_url('login'),['class' => 'loginform', 'id' => 'loginform']); ?>
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
                                            'type' => 'text'
                                        ];
                                        echo form_input($identity);
                                    ?>
                                   
                                </div><br />
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <?php
                                        $password = [
                                            'name' => 'password',
                                            'id'   => 'password',
                                            'class'  => 'form-control',
                                            'type' => 'password',
                                        ];
                                        echo form_input($password);
                                    ?>
                                </div><br />
                                <div class="footer-links">
                                    <a href="<?php echo base_url('forgot-password'); ?>">Forgot Password?</a>

                                      <?php echo form_submit('submit', 'signin', ['class' => 'btn btn-success submitbutton']); ?>
                                   
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.login-box -->
    <?php echo view('Modules\Auth\Views\footer_login'); ?>