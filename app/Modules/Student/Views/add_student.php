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
                    <h1>New students</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('bus-companies'); ?>"><?php echo lang('BusCompany.label_module_name') ?></a></li>
                        <li class="breadcrumb-item active">New</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php echo form_open(base_url('student/add'), ['class' => 'studentForm']); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo lang('Student.student_details') ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.firstname')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'firstname',
                                        'id'    => 'firstname',
                                        'class'  => 'form-control',
                                        'value' => set_value('firstname'),
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.lastname')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                   <?php
                                    $lastname = [
                                        'name'  => 'lastname',
                                        'id'    => 'lastname',
                                        'class'  => 'form-control',
                                        'value' => set_value('lastname'),
                                    ];
                                    echo form_input($lastname);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.state')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $state_id = [
                                        'name'  => 'state_id',
                                        'id'    => 'state_id',
                                        'class'  => 'form-control',
                                        'value' => set_value('state_id'),
                                    ];
                                    echo form_input($state_id);
                                    ?>
                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.address1')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $address1 = [
                                        'name'  => 'address1',
                                        'id'    => 'address1',
                                        'class'  => 'form-control',
                                        'value' => set_value('address1'),
                                    ];
                                    echo form_input($address1);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.address2')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $address2 = [
                                        'name'  => 'address2',
                                        'id'    => 'address2',
                                        'class'  => 'form-control',
                                        'value' => set_value('address2'),
                                    ];
                                    echo form_input($address2);
                                    ?>
                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.state_dropdown')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php

                                    $options = array();
                                    foreach($state_master as $key => $value)
                                    {
                                        $options[$value->id] = $value->state_name;
                                    }

                                    $attr = [
                                        'id' => 'state',
                                        'class' => 'form-control',
                                        'onChange' => 'load_cities();'
                                    ];
                                    echo form_dropdown('state', $options,'',$attr);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.city')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <select name="city" id="city" class="form-control " aria-invalid="false">

                                    </select>
                                </div>
                            </div>        
                            
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.zipcode')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                     $zipcode = [
                                        'name'  => 'zipcode',
                                        'id'    => 'zipcode',
                                        'class'  => 'form-control',
                                        'value' => set_value('zipcode'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($zipcode);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.dob')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $dob = [
                                        'name'  => 'dob',
                                        'id'    => 'dob',
                                        'class'  => 'form-control',
                                        'value' => set_value('dob'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($dob);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.email')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                     $email = [
                                        'name'  => 'email',
                                        'id'    => 'email',
                                        'class'  => 'form-control',
                                        'value' => set_value('email'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($email);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.district_code')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $district_code = [
                                        'name'  => 'district_code',
                                        'id'    => 'district_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('district_code'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($district_code);
                                    ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.school_destination')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $school_destination = [
                                        'name'  => 'school_destination',
                                        'id'    => 'school_destination',
                                        'class'  => 'form-control',
                                        'value' => set_value('school_destination'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($school_destination);
                                    ?>

                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.special_transportations')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $special_transportations = [
                                        'name'  => 'special_transportations',
                                        'class'    => 'special_transportations', 
                                    ];

                                    echo form_radio($special_transportations,'Yes',FALSE).form_label('Yes');
                                    echo form_radio($special_transportations,'No',FALSE).form_label('No');
                                    ?>

                                </div>
                            </div>

                             <div class="form-group row spl_transportation">
                                <div class="input-group col-sm-9">
                                    <?php
                                      $spl_transportation_list = [
                                        'name'  => 'spl_transportation_list',
                                        'id'    => 'spl_transportation_list',
                                        'class'  => 'form-control',
                                        'value' => set_value('spl_transportation_list'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($spl_transportation_list);
                                    ?>

                                </div>
                            </div>

                            <?php echo form_label(lang('Student.emergency_contact')); ?>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.firstname')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $emergency_firstname = [
                                        'name'  => 'emergency_firstname',
                                        'id'    => 'emergency_firstname',
                                        'class'  => 'form-control',
                                        'value' => set_value('emergency_firstname'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($emergency_firstname);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.lastname')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $emergency_lsstname = [
                                        'name'  => 'emergency_lsstname',
                                        'id'    => 'emergency_lsstname',
                                        'class'  => 'form-control',
                                        'value' => set_value('emergency_lsstname'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($emergency_lsstname);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.title')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $title = [
                                        'name'  => 'title',
                                        'id'    => 'title',
                                        'class'  => 'form-control',
                                        'value' => set_value('title'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($title);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Student.phone_number')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $emergency_phone_number = [
                                        'name'  => 'emergency_phone_number',
                                        'id'    => 'emergency_phone_number',
                                        'class'  => 'form-control',
                                        'value' => set_value('emergency_phone_number'),
                                        'type' => 'text',
                                    ];
                                    echo form_input($emergency_phone_number);
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
                <?php echo form_submit('submit', lang('BusCompany.label_button_create'), ['class' => 'btn btn-info ']); ?>
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

<script src="<?php echo base_url('assets/js/student/student.js'); ?>"></script>
<script>


</script>
<?php echo view('footer'); ?>