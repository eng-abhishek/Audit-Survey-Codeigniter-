<?php
echo view('header_no_session');
?>
<style>
.main-header { display: none; }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container-fluid">
            <?php echo form_open(base_url('oac-invites/user-register/'.$hash), ['class' => 'registerOACForm']); ?>
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Personal Detail</h3>
                        </div>
                        <div class="card-body">
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Districts', 'name',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $options = ['' => '--Select--'];
                                    foreach($district as $key => $value)
                                    {
                                        $options[$value['id']] = $value['district_name'];
                                    }

                                    $other_attrs = ["id" => "district", "class" => "form-control"];

                                    echo form_dropdown('districts', $options, 'large', $other_attrs);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('School Destination', 'school_destination',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $school_destination_opt = ['' => '--Select--'];
                                    foreach ($school_destinations as $school_destination) {
                                        $school_destination_opt[$school_destination->id] =  $school_destination->school_name; 
                                    }
                                    $attr = [
                                        'name'  => 'school_destination_id',
                                        'id'    => 'school_destination_id',
                                        'class'  => 'custom-select'
                                    ];
                                    echo form_dropdown('school_destination_id',$school_destination_opt,'',$attr);
                                    ?>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('First Name', 'name',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'name',
                                        'id'    => 'name',
                                        'class'  => 'form-control',
                                        'value' => set_value('name')
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Last Name', 'lastname',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $last_name = [
                                        'name'  => 'last_name',
                                        'id'    => 'last_name',
                                        'class'  => 'form-control',
                                        'value' => set_value('last_name')
                                    ];
                                    echo form_input($last_name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Title / Role', 'title',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $title_role = [
                                        'name'    => 'title_role',
                                        'id'      => 'title_role',
                                        'class'  => 'form-control',
                                        'type'    => 'text'
                                    ];
                                    echo form_input($title_role);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('State', 'state',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                        $options = array('' => '--Select--');
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
                                    <?php echo form_label('City', 'city',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $city = [
                                        'name'    => 'city',
                                        'id'      => 'city',
                                        'class'  => 'form-control',
                                        'type'    => 'text'
                                    ];
                                    echo form_input($city);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Zipcode', 'zipcode',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $zipcode = [
                                        'name'    => 'zipcode',
                                        'id'      => 'zipcode',
                                        'class'  => 'form-control',
                                        'type'    => 'text'
                                    ];
                                    echo form_input($zipcode);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Contact Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Auth.edit_user_email_label'), 'email',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $email = [
                                        'name'  => 'email',
                                        'id'    => 'email',
                                        'class'  => 'form-control',
                                        'value' => set_value('email',$email ?: '')
                                    ];
                                    echo form_input($email);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Ext', 'ext',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $ext = [
                                        'name'  => 'ext',
                                        'id'    => 'ext',
                                        'class'  => 'form-control',
                                        'value' => set_value('ext')
                                    ];
                                    echo form_input($ext);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Auth.edit_user_phone_label'), 'phone',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $phone = [
                                        'name'  => 'phone',
                                        'id'    => 'phone',
                                        'class'  => 'form-control',
                                        'value' => set_value('phone')
                                    ];
                                    echo form_input($phone);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Office Address 1', 'address',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $address = [
                                        'name'  => 'address',
                                        'id'    => 'address',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('address')
                                    ];
                                    echo form_textarea($address);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Office Address 2', 'office_address',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $office_address = [
                                        'name'  => 'office_address',
                                        'id'    => 'office_address',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('office_address'),
                                    ];
                                    echo form_textarea($office_address);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Fax', 'fax'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $fax = [
                                        'name'  => 'fax',
                                        'id'    => 'fax',
                                        'class'  => 'form-control',
                                        'value' => set_value('fax'),
                                    ];
                                    echo form_input($fax);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <?php
                                    $sms_survey_completion = [
                                        'name'  => 'sms_survey_completion',
                                        'id'    => 'sms_survey_completion',
                                        'class'  => 'custom-control-input',
                                        'value' => '1'
                                    ];
                                    echo form_checkbox($sms_survey_completion);
                                    echo form_label('Receive all survey completion', 'sms_survey_completion', ['class' => 'custom-control-label']); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <?php
                                    $receive_alerts = [
                                        'name'  => 'sms_receive_alerts',
                                        'id'    => 'sms_receive_alerts',
                                        'class'  => 'custom-control-input',
                                        'value' => '1'
                                    ];
                                    echo form_checkbox($receive_alerts);
                                    echo form_label('Receive Survey Alerts', 'sms_receive_alerts', ['class' => 'custom-control-label']); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <?php
                                    $email_survey_completion = [
                                        'name'  => 'email_survey_completion',
                                        'id'    => 'email_survey_completion',
                                        'class'  => 'custom-control-input',
                                        'checked' => TRUE,
                                        'value' => '1'
                                    ];
                                    echo form_checkbox($email_survey_completion);
                                    echo form_label('Receive all survey completion', 'email_survey_completion', ['class' => 'custom-control-label']); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <?php
                                    $email_survey_alerts = [
                                        'name'  => 'email_survey_alerts',
                                        'id'    => 'email_survey_alerts',
                                        'class'  => 'custom-control-input',
                                        'value' => '1',
                                        'checked' => TRUE,
                                    ];
                                    echo form_checkbox($email_survey_alerts);
                                    echo form_label('Receive Survey Alerts', 'email_survey_alerts', ['class' => 'custom-control-label']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php echo form_submit('submit', 'Register', ['class' => 'btn btn-info ']); ?>
            </div>
            <?php echo form_close(); ?>
        </div>
    </section>
</div>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<?php echo view('scripts'); ?>
<script src="<?php echo base_url('assets/js/oacuser/register_oac.js'); ?>"></script>
<?php echo view('footer'); ?>