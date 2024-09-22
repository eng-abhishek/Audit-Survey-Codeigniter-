<?php
echo view('header');
echo view('sidebar');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <?php if($error_msg) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php 
                            foreach($error_msg as $key => $value)
                            {
                                echo $value. " already exist in users"."<br>";
                            }
                         
                        ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                <?php } ?>
            <?php echo form_open(base_url('oac-invites/invite'), ['id' =>'oacinvites','class' => 'validateForm1']); ?>
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Invite OAC</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('User Type'); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'user_code',
                                        'id'    => 'name',
                                        'class' => 'form-control',
										'disabled' => 'disabled',
                                        'value' => 'OAC',
                                        'required' => TRUE
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Email Id(s)','',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $email_ids = [
                                        'name'  => 'email_ids',
                                        'id'    => 'email_ids',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('email_ids'),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($email_ids);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="form-group">
                <?php echo form_submit('submit', 'Submit', ['class' => 'btn btn-info ']); ?>
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- /.login-box -->
<?php echo view('scripts'); ?>
<script src="<?php echo base_url('assets/js/oacuser/oacuser.js'); ?>"></script>
<?php echo view('footer'); ?>