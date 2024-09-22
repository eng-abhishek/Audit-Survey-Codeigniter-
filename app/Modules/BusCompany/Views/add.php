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
                    <h1>New Bus Company</h1>
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
            <?php echo form_open(base_url('bus-companies/add'), ['class' => 'buscompany']); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Bus Company Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_name'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'name',
                                        'id'    => 'name',
                                        'class'  => 'form-control',
                                        'value' => set_value('name'),
                                        'required' => TRUE,
                                        'maxlength' => '150',
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>
                          <!--   <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_status')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                  <?php
                                        $status = [
                                            'name'    => 'is_active_status',
                                            'id'      => 'is_active_status',
                                            'class'  => 'form-control',
                                            'type'    => 'checkbox',
                                            'data-on-text' => 'Active',
                                            'data-off-text' => 'Inactive',
                                            'data-bootstrap-switch' => '',
                                            'data-off-color' => 'danger',
                                            'data-on-color' => 'success',
                                            'value' => '0'
                                        ];
                                        echo form_input($status);
                                    ?>
                                     <input id='is_active' type='hidden' value='0' name='is_active'>  
                                </div>
                            </div>
 -->
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_address'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class=" col-sm-9">
                                    <?php
                                    $address1 = [
                                        'name'  => 'address1',
                                        'id'    => 'address1',
                                        'class'  => 'form-control',
                                        'value' => set_value('address1'),
                                        'type' => 'text',
                                        'required' => TRUE
                                    ];
                                    echo form_input($address1);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_address2'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $address2 = [
                                        'name'  => 'address2',
                                        'id'    => 'address2',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('address2'),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($address2);
                                    ?>

                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_state'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php

                                    $options = array(''=>'-- Select --');
                                    foreach($state_master as $key => $value)
                                    {
                                        $options[$value['id']] = $value['state_name'];
                                    }

                                    $attr = [
                                        'id' => 'state',
                                        'class' => 'form-control',
                                        //'onChange' => 'load_cities();',
                                        'required' => TRUE
                                    ];
                                    echo form_dropdown('state', $options,'',$attr);
                                    ?>

                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_city'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                     $city = [
                                        'name'  => 'city',
                                        'id'    => 'city',
                                        'class'  => 'form-control',
                                        'value' => set_value('city'),
                                        'type' => 'text',
                                        'required' => TRUE,
                                        'maxlength' => '100'
                                    ];
                                    echo form_input($city);
                                    ?>
                                </div>
                            </div>

                            
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_zipcode'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                     $zipcode = [
                                        'name'  => 'zipcode',
                                        'id'    => 'zipcode',
                                        'class'  => 'form-control',
                                        'value' => set_value('zipcode'),
                                        'type' => 'text',
                                        'required' => TRUE,
                                        'maxlength' => '10',
                                    ];
                                    echo form_input($zipcode);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_mobile'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                      $mobile = [
                                        'name'  => 'mobile',
                                        'id'    => 'mobile',
                                        'class'  => 'form-control',
                                        'value' => set_value('mobile'),
                                        'type' => 'text',
                                        'required' => TRUE,
                                        'maxlength' => '15',
                                    ];
                                    echo form_input($mobile);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_ext'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                     $ext = [
                                        'name'  => 'ext',
                                        'id'    => 'ext',
                                        'class'  => 'form-control',
                                        'value' => set_value('ext'),
                                        'type' => 'text',
                                        'required' => TRUE,
                                        'maxlength' => '10',
                                    ];
                                    echo form_input($ext);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_email'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                      $email = [
                                        'name'  => 'email',
                                        'id'    => 'email',
                                        'class'  => 'form-control',
                                        'value' => set_value('email'),
                                        'type' => 'text',
                                        'required' => TRUE,
                                        'maxlength' => '100',
                                    ];
                                    echo form_input($email);
                                    ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_contractor_code'),'',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                      $contractor_code = [
                                        'name'  => 'contractor_code',
                                        'id'    => 'contractor_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('contractor_code'),
                                        'type' => 'text',
                                        'required' => TRUE,
                                        'maxlength' => '100',
                                    ];
                                    echo form_input($contractor_code);
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

<script src="<?php echo base_url('assets/js/buscompany/buscompany.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/common.js'); ?>"></script>

<script>
$(function () {
    load_cities();
});

</script>
<?php echo view('footer'); ?>