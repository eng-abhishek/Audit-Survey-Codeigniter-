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
                    <h1>View Bus Company</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('bus-companies'); ?>"><?php echo lang('BusCompany.label_module_name') ?></a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
          
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Bus Company Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_name')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'name',
                                        'id'    => 'name',
                                        'class'  => 'form-control',
                                        'value' => $record->company_name,
                                        'readonly'=>'true'
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
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
                                            'value' => $record->is_active,
                                            'readonly'=>'true'
                                        ];

                                        if($record->is_active == 1)
                                        {
                                            $status['checked'] = 'checked';
                                        }
                                        echo form_input($status);
                                    ?>
                                     <input id='is_active' type='hidden' value='0' name='is_active'>  
                                </div>
                            </div>
 -->
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_address')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $address1 = [
                                        'name'  => 'address1',
                                        'id'    => 'address1',
                                        'class'  => 'form-control',
                                        'value' => $record->address1,
                                        'type' => 'text',
                                        'readonly'=>'true'
                                    ];
                                    echo form_input($address1);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_address2')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $address2 = [
                                        'name'  => 'address2',
                                        'id'    => 'address2',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => $record->address2,
                                        'readonly'=>'true'
                                    ];
                                    echo form_textarea($address2);
                                    ?>

                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_state')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php

                                    $options = array();
                                    foreach($state_master as $key => $value)
                                    {
                                        $options[$value['id']] = $value['state_name'];
                                    }

                                    $attr = [
                                        'id' => 'state',
                                        'class' => 'form-control',
                                        'onChange' => 'load_cities();',
                                        'readonly'=>'true'
                                    ];
                                    echo form_dropdown('state', $options,$record->state,$attr);
                                    ?>

                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_city')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <select name="city" id="city" class="form-control is-valid" aria-invalid="false" readonly>

                                    </select>
                                </div>
                            </div>

                            
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_zipcode')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                     $zipcode = [
                                        'name'  => 'zipcode',
                                        'id'    => 'zipcode',
                                        'class'  => 'form-control',
                                        'value' => $record->zipcode,
                                        'type' => 'text',
                                        'readonly'=>'true'
                                    ];
                                    echo form_input($zipcode);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_mobile')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $mobile = [
                                        'name'  => 'mobile',
                                        'id'    => 'mobile',
                                        'class'  => 'form-control',
                                        'value' => $record->phone,
                                        'type' => 'text',
                                        'readonly'=>'true'
                                    ];
                                    echo form_input($mobile);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_ext')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                     $ext = [
                                        'name'  => 'ext',
                                        'id'    => 'ext',
                                        'class'  => 'form-control',
                                        'value' => $record->extension,
                                        'type' => 'text',
                                        'readonly'=>'true'
                                    ];
                                    echo form_input($ext);
                                    ?>

                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_email')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $email = [
                                        'name'  => 'email',
                                        'id'    => 'email',
                                        'class'  => 'form-control',
                                        'value' => $record->email,
                                        'type' => 'text',
                                        'readonly'=>'true'
                                    ];
                                    echo form_input($email);
                                    ?>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('BusCompany.label_company_contractor_code')); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                      $contractor_code = [
                                        'name'  => 'contractor_code',
                                        'id'    => 'contractor_code',
                                        'class'  => 'form-control',
                                        'value' => $record->contractor_code,
                                        'type' => 'text',
                                        'readonly'=>'true'
                                    ];
                                    echo form_input($contractor_code);
                                    ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <a href="<?php echo base_url('bus-companies/edit/'.service('request')->uri->getSegment(3)); ?>" class="btn btn-info">Edit</a>

                 
                                <a href="#" class="btn btn-info del_bus_company" data-id="<?php echo service('request')->uri->getSegment(3); ?>">Delete</a>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
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
<script>
$(function () {
    load_cities(<?php echo $record->city; ?>);
});

</script>
<?php echo view('footer'); ?>