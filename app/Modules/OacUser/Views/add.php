<?php
echo view('header');
echo view('sidebar');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>New School District</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('school-districts'); ?>">School Dstricts</a></li>
                        <li class="breadcrumb-item active">New</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php echo form_open(base_url('school-districts/add'), ['class' => 'validateForm']); ?>
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">School Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Name', 'name'); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'name',
                                        'id'    => 'name',
                                        'class'  => 'form-control',
                                        'value' => set_value('name'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($name);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Billing Address', 'billing_address'); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $billing_address = [
                                        'name'  => 'billing_address',
                                        'id'    => 'billing_address',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('billing_address'),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($billing_address);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-address-card"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <?php
                                    $active = [
                                        'name'  => 'active',
                                        'id'    => 'active',
                                        'class'  => 'custom-control-input',
                                        'checked' => true
                                    ];
                                    echo form_checkbox($active);
                                    echo form_label('Status', 'active', ['class' => 'custom-control-label']); ?>
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
                <?php echo form_submit('submit', 'Create', ['class' => 'btn btn-info ']); ?>
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
<?php echo view('scripts');
echo view('footer'); ?>