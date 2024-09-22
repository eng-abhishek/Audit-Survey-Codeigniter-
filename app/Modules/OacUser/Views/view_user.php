<?php
echo view('header');
echo view('sidebar');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container-fluid">
            <?php echo form_open(base_url('oac-invites/approve-user/'.$hash), ['class' => 'createOACForm']); ?>
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Personal Detail</h3>
                        </div>
                        <div class="card-body">
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Districts', 'name'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $options = ['' => '--Select--'];
                                    foreach($district as $key => $value)
                                    {
                                        $options[$value->id] = $value->district_name;
                                    }

                                    $other_attrs = ["id" => "district", "class" => "form-control"];

                                    echo form_dropdown('districts', $options, $record['school_district_id'], $other_attrs);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('School Destination', 'school_destination'); ?>
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
                                        'class'  => 'custom-select',
                                    ];
                                    echo form_dropdown('school_destination_id',$school_destination_opt,$record['school_destination_id'],$attr);
                                    ?>
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('First Name', 'name'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $name = [
                                        'name'  => 'name',
                                        'id'    => 'name',
                                        'class'  => 'form-control',
                                        'value' => set_value('name', $record['first_name'] ?: ''),
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Last Name', 'lastname'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $last_name = [
                                        'name'  => 'last_name',
                                        'id'    => 'last_name',
                                        'class'  => 'form-control',
                                        'value' => set_value('last_name', $record['last_name'] ?: '')
                                    ];
                                    echo form_input($last_name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Title / Role', 'title'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $title_role = [
                                        'name'    => 'title_role',
                                        'id'      => 'title_role',
                                        'class'  => 'form-control',
                                        'type'    => 'text',
                                        'value' => set_value('title_role', $record['title_role'] ?: '')
                                    ];
                                    echo form_input($title_role);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('State', 'state'); ?>
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
                                        echo form_dropdown('state', $options,$record['state'],$attr);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('City', 'city'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $city = [
                                        'name'    => 'city',
                                        'id'      => 'city',
                                        'class'  => 'form-control',
                                        'type'    => 'text',
                                        'value' => set_value('city', $record['city'] ?: '')
                                    ];
                                    echo form_input($city);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Zipcode', 'zipcode'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $zipcode = [
                                        'name'    => 'zipcode',
                                        'id'      => 'zipcode',
                                        'class'  => 'form-control',
                                        'type'    => 'text',
                                        'value' => set_value('zipcode', $record['zipcode'] ?: '')
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
                                    <?php echo form_label(lang('Auth.edit_user_email_label'), 'email'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $email = [
                                        'name'  => 'email',
                                        'id'    => 'email',
                                        'class'  => 'form-control',
                                        'value' => set_value('email', $record['email'] ?: '')
                                    ];
                                    echo form_input($email);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Ext', 'ext'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $ext = [
                                        'name'  => 'ext',
                                        'id'    => 'ext',
                                        'class'  => 'form-control',
                                        'value' => set_value('ext', $record['extension'] ?: '')
                                    ];
                                    echo form_input($ext);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('Auth.edit_user_phone_label'), 'phone'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $phone = [
                                        'name'  => 'phone',
                                        'id'    => 'phone',
                                        'class'  => 'form-control',
                                        'value' => set_value('phone', $record['phone'] ?: '')
                                    ];
                                    echo form_input($phone);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Office Address 1', 'address'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $address = [
                                        'name'  => 'address',
                                        'id'    => 'address',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('address', $record['office_address1'] ?: '')
                                    ];
                                    echo form_textarea($address);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Office Address 2', 'office_address'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $office_address = [
                                        'name'  => 'office_address',
                                        'id'    => 'office_address',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('office_address',$record['office_address2'] ?: ''),
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
                                        'value' => set_value('fax',$record['fax'] ?: ''),
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

                                    if($record['sms_survey_completion'] == 1)
                                    {
                                        $sms_survey_completion['checked'] = TRUE;
                                    }

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

                                    if($record['sms_survey_alert'] == 1)
                                    {
                                        $receive_alerts['checked'] = TRUE;
                                    }

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
                                        'value' => '1'
                                    ];

                                    if($record['email_survey_completion'] == 1)
                                    {
                                        $email_survey_completion['checked'] = TRUE;
                                    }

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
                                    ];

                                    if($record['email_survey_alert'] == 1)
                                    {
                                        $email_survey_alerts['checked'] = TRUE;
                                    }

                                    echo form_checkbox($email_survey_alerts);
                                    echo form_label('Receive Survey Alerts', 'email_survey_alerts', ['class' => 'custom-control-label']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?php
                    if($record['registration_status'] != '1')
                    {
                        echo form_button(['name'=>'button','id'=>'approve_btn','value'=>'true','type'=> 'button','content' => 'Approve','class' => 'btn btn-info ']); 
                    }
                ?>
                <?php 
                    if($record['registration_status'] == '0')
                    {
                        echo form_button(['name'=>'button','id'=>'reject_btn','value'=>'true','type'=> 'button','content' => 'Reject','class' => 'btn btn-info ']); 
                    }
                ?>
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
<script>

$('#approve_btn').click(function(){
	Swal.fire({
			title: 'Do you want to Approve?',
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: 'Yes',
			denyButtonText: 'No',
		}).then((result) => {
		if (result.isConfirmed) {
			$('.createOACForm').append('<input type="hidden" name="btn_type" value="approve" />');
			$('.createOACForm').submit();
		}
	})
});
	

$('#reject_btn').click(function(){
	Swal.fire({
			title: 'Do you want to Reject?',
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: 'Yes',
			denyButtonText: 'No',
		}).then((result) => {
		if (result.isConfirmed) {
			$('.createOACForm').append('<input type="hidden" name="btn_type" value="reject" />');
			$('.createOACForm').submit();
		} 
	})
});

$(function () {
     $(".createOACForm").validate({
        rules: {
          districts: {
            required: true,
          },
          school_destination_id: {
            required: true,
          },
          name: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          last_name: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          address1: {
            required: true,
          },
          title_role: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          city: {
            required: true,
            minlength : 3,
            maxlength: 150
          },
          state: {
            required: true,
          },
          zipcode: {
            required: true,
            digits: true,
            minlength : 3,
            maxlength: 30
          },
          email: {
            required: true,
            email: true,
            minlength : 3,
            maxlength: 150
          },
          ext: {
            required: true,
            digits: true,
            minlength : 3,
            maxlength: 20
          },
          phone: {
            required: true,
            digits: true,
            minlength : 3,
            maxlength: 30
          },
          address: {
            required: true,
            minlength : 3,
          },
          fax: {
            digits: true,
            minlength : 3,
          },
        },
    });   
});
</script>
<?php echo view('footer'); ?>