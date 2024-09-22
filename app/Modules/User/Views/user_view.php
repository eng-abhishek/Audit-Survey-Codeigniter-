<?php
echo view('header');
echo view('sidebar');
?>
<<<<<<< HEAD
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
            <div class="container-fluid">
                  <div class="row mb-2">
                        <div class="col-sm-6">
                              <h1>View User</h1>
=======
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit User</h1>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo form_label('User Type', 'group_id',['class' => 'field_required']); ?></label>
                            <?php
                                $options = [];
                                foreach ($groups as $group) {
                                    if($group->id != 1)
                                    {
                                        $options[$group->id] = $group->code . ' - ' . $group->name;
                                    }
                                }
                                $attr = [
                                    'class'  => 'custom-select gps',
                                    'disabled' => 'disabled'
                                ];
                                echo form_dropdown('group_id',$options,$user['group_id'],$attr);
                            ?>
                        <input type="hidden" name="group_id" id="group_id" value="<?php echo $user['group_id']; ?>" />
                    </div>

                     <?php if($user['group_id'] == '6') {  ?>
                         <div class="form-group ">
                            <?php 
                            echo form_label('School Destination', 'school_destination'); 
                            $school_destination_opt = ['' => '--Select--'];
                            foreach ($school_destinations as $school_destination) {
                                $school_destination_opt[$school_destination->id] =  $school_destination->school_name; 
                            }
                            $attr = [
                                'name'  => 'school_destination_id',
                                'id'    => 'school_destination_id',
                                'class'  => 'custom-select'
                            ];
                            echo form_dropdown('school_destination_id',$school_destination_opt,$user['school_destination_id'],$attr);
                            ?>
>>>>>>> 2e13520e6b21337514c66faccdf98b3d30437ce6
                        </div>
                    <?php } ?>

                    <?php
                        $disabled = ''; 
                        if($current_user->group_id == '4' || $current_user->group_id == '2' || $current_user->group_id == '6')
                        {   
                            $disabled = 'disabled';
                        }


                        ?>

                        <?php if($user['group_id'] == '3' || $user['group_id'] == '5' || $user['group_id'] == '7')
                                { ?>
                            <div class="form-group " id="">
                                <?php echo form_label('Parent User', 'parent_user',['class' => 'parent_user_type']); ?>
                                
                               <select class="form-control" name="parent_user_id" id="parent_user_id" <?php echo $disabled; ?> >

                               </select>
                                <input type="hidden" class="hidden_parent_user" id="hidden_parent_user" value="<?php echo $user['parent_user_id']; ?>" />
                            </div>
                        <?php } ?>

                        <?php if($user['group_id'] == '7') { ?>
                             <div class="form-group row" id="school_destination">
                                    <?php echo form_label('School Destination'); ?>
                                    <label id="school_destination_text"></label>
                            </div>
                        <?php } ?>

                        <?php 
                        if($user['group_id'] != '7')
                        {
                        ?>
                        <div class="form-group row">
                            <?php echo form_label('Districts', 'name',['class' => 'field_required']); ?>
                       
                            <?php
                            $options = [];
                        
                            $other_attrs = ["id" => "district", "class" => "form-control"];

                            if($user['group_id'] != '6')
                            {
                                $other_attrs['multiple'] = "multiple";
                            }
                           
                            echo form_dropdown('districts[]', $options, $user['district_name'], $other_attrs);
                            ?>
                        </div>

                        <?php
                        }
                        ?>
                </div>
            </div>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="button-switch float-left">
                        <?php
                            $checked = '';
                            if($user['active'] == '1')
                            {
                                  $checked = 'checked';
                            }
                        ?>
                        <input type="checkbox" name="active" value="1" id="switch-green" class="switch" <?php echo $checked; ?> />
                        <label for="switch-blue" class="lbl-off">inactive</label>
                        <label for="switch-blue" class="lbl-on">active</label>
                      </div>

                      <div class="delete-icon float-right"><a href="#" class="delete-user" data-id="<?php echo service('request')->uri->getSegment(3); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="38" height="37" viewBox="0 0 38 37">
                            <g id="trash" transform="translate(-2 -2)">
                              <rect id="Rectangle_1571" data-name="Rectangle 1571" width="24" height="28" transform="translate(9 10)" fill="none" stroke="#ff2e00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                              <line id="Line_8" data-name="Line 8" x2="36" transform="translate(3 10)" fill="none" stroke="#ff2e00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                              <line id="Line_9" data-name="Line 9" x2="9" transform="translate(16 3)" fill="none" stroke="#ff2e00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                              <line id="Line_10" data-name="Line 10" y2="17" transform="translate(21 16)" fill="none" stroke="#ff2e00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                              <line id="Line_11" data-name="Line 11" y2="17" transform="translate(25 16)" fill="none" stroke="#ff2e00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                              <line id="Line_12" data-name="Line 12" y2="17" transform="translate(17 16)" fill="none" stroke="#ff2e00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </g>
                          </svg>
                    </a></div>
                </div>

            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php if($user['group_id'] == '2') { ?>
     <section class="content">
      <div class="container-fluid">
        <div class="card form-box">
            <div class="card-header">
              <h3 class="card-title">Regional Transportation Authority</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <?php 
                            echo form_label('Name of Organization', 'name',['class' => 'field_required']); 
                            $organization_name = [
                                'id'    => 'organization_name',
                                'class'  => 'form-control',
                                'value' => set_value('organization_name', $user['organization_name'] ?: '')
                            ];
                            echo form_input($organization_name);
                        ?>                
                    </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo form_label('Billing Address 1', 'billing_address_1',['class' => 'field_required']); 
                                $billing_address_1 = [
                                    'id'    => 'billing_address_1',
                                    'class'  => 'form-control',
                                    'rows' => 2,
                                    'value' => set_value('billing_address_1', $user['billing_address_1'] ?: '')
                                ];
                                echo form_textarea($billing_address_1);
                            ?>                
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <?php 
                            echo form_label('Billing Address 2', 'billing_address_2');
                            $billing_address_2 = [
                                'id'    => 'billing_address_2',
                                'class'  => 'form-control',
                                'rows' => 2,
                                'value' => set_value('billing_address_2', $user['billing_address_2'] ?: '')
                            ];
                            echo form_textarea($billing_address_2);
                        ?>                
                        </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <?php 
                            echo form_label('State', 'state',['class' => 'field_required']);
                            $options = array('' => '--Select--');
                            foreach($state_master as $key => $value)
                            {
                                $options[$value->id] = $value->state_name;
                            }

                            $attr = [
                                'id' => 'billing_state',
                                'class' => 'form-control'
                            ];
                            echo form_dropdown('billing_state', $options,$user['billing_state'],$attr);
                        ?>                
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <?php 
                            echo form_label('City', 'city',['class' => 'field_required']);
                            $billing_city = [
                                'id'      => 'billing_city',
                                'class'  => 'form-control',
                                'type'    => 'text',
                                'value' => set_value('billing_city', $user['billing_city'] ?: '')
                            ];
                            echo form_input($billing_city);
                        ?>                
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <?php 
                            echo form_label('Billing Zipcode', 'billing_zipcode',['class' => 'field_required']);
                            $billing_zipcode = [
                                'id'      => 'billing_zipcode',
                                'class'  => 'form-control',
                                'type'    => 'text',
                                'value' => set_value('billing_zipcode', $user['billing_zipcode'] ?: '')
                            ];
                            echo form_input($billing_zipcode);
                        ?>                
                    </div>
                    </div>
                  </div>

                   <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group only_rtc">
                        <?php 
                            echo form_label('Website URL', 'website_url');
                            $website_url = [
                                'id'      => 'website_url',
                                'class'  => 'form-control',
                                'type'    => 'url',
                                'value' => set_value('website_url', $user['website_url'] ?: '')
                            ];
                            echo form_input($website_url);
                        ?>                
                    </div>
                    </div>
                  </div>
            </div>
            <!-- /.card-body -->
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card form-box">
            <div class="card-header">
              <h3 class="card-title">LTC</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                          <?php echo form_label('First Name', 'name',['class' => 'field_required']); 
                                $name = [
                                    'id'    => 'name',
                                    'class'  => 'form-control',
                                    'value' => set_value('name', $user['first_name'] ?: ''),
                                    'required' => TRUE
                                ];
                                echo form_input($name);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                           <?php echo form_label('Last Name', 'lastname',['class' => 'field_required']); 
                                $last_name = [
                                    'id'    => 'last_name',
                                    'class'  => 'form-control',
                                    'value' => set_value('last_name', $user['last_name'] ?: ''),
                                    'required' => TRUE
                                ];
                                echo form_input($last_name);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                           <?php echo form_label('Title / Role', 'title',['class' => 'field_required']);
                                $title_role = [
                                    'id'      => 'title_role',
                                    'class'  => 'form-control',
                                    'type'    => 'text',
                                    'required' => TRUE,
                                    'value' => set_value('title_role', $user['title_role'] ?: ''),
                                ];
                                echo form_input($title_role);
                            ?>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                             <?php echo form_label('Office Address 1', 'address',['class' => 'field_required']); 
                                $address = [
                                    'id'    => 'address',
                                    'class'  => 'form-control',
                                    'rows' => 2,
                                    'value' => set_value('address', $user['address'] ?: ''),
                                    'required' => TRUE
                                ];
                                echo form_textarea($address);
                             ?>
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo form_label('Office Address 2', 'office_address'); 
                                $office_address = [
                                    'id'    => 'office_address',
                                    'class'  => 'form-control',
                                    'rows' => 2,
                                    'value' => set_value('office_address', $user['office_address2'] ?: ''),
                                ];
                                echo form_textarea($office_address);
                            ?>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                          <?php 
                            echo form_label('City', 'city',['class' => 'field_required']); 
                            $city = [
                                'id'      => 'city',
                                'class'  => 'form-control',
                                'type'    => 'text',
                                'required' => TRUE,
                                'value' => set_value('city', $user['city'] ?: ''),
                            ];
                            echo form_input($city);
                          ?>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo form_label('State', 'state',['class' => 'field_required']); 
                                $options = array('' => '--Select--');
                                foreach($state_master as $key => $value)
                                {
                                    $options[$value->id] = $value->state_name;
                                }

                                $attr = [
                                    'id' => 'state',
                                    'class' => 'form-control'
                                ];
                                echo form_dropdown('state', $options,$user['state'],$attr);
                            ?>            
                          </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <?php 
                            echo form_label('Zipcode', 'zipcode',['class' => 'field_required']); 
                            $zipcode = [
                                'id'      => 'zipcode',
                                'class'  => 'form-control',
                                'type'    => 'text',
                                'required' => TRUE,
                                'value' => set_value('zipcode', $user['zipcode'] ?: ''),
                            ];
                            echo form_input($zipcode);
                            ?>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                             <?php 
                                echo form_label('Mobile Number', 'phone',['class' => 'field_required']); 
                                $phone = [
                                    'id'    => 'phone',
                                    'class'  => 'form-control',
                                    'value' => set_value('phone', $user['phone'] ?: ''),
                                    'required' => TRUE
                                ];
                                echo form_input($phone);
                             ?>
                          </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                            <?php 
                                echo form_label(lang('Auth.edit_user_email_label'), 'email',['class' => 'field_required']); 
                                $email = [
                                    'id'    => 'email',
                                    'class'  => 'form-control',
                                    'value' => set_value('email', $user['email'] ?: ''),
                                    'required' => TRUE
                                ];
                                echo form_input($email);
                            ?>
                          </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                             <?php 
                                echo form_label('Fax', 'fax'); 
                                $fax = [
                                    'id'    => 'fax',
                                    'class'  => 'form-control',
                                    'value' => set_value('fax', $user['fax'] ?: ''),
                                ];
                                echo form_input($fax);
                             ?>
                          </div>
                    </div>
                  </div>

                   <div class="row notification_section">
                      <div class="col-sm-6">
                        <div class="row">
                            <?php echo form_label('SMS Notifications'); ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                    <?php
                                         $sms_survey_completion = [
                                        'id'    => 'sms_survey_completion',
                                        'class'  => 'custom-control-input',
                                        'value' => '1'
                                    ];

                                    if($user['sms_survey_completion'] == '1')
                                    {
                                          $sms_survey_completion['checked'] = true;
                                    }

                                    echo form_checkbox($sms_survey_completion);
                                    echo form_label('Receive all survey completion', 'sms_survey_completion', ['class' => 'custom-control-label']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                    <?php
                                        $receive_alerts = [
                                        'id'    => 'sms_receive_alerts',
                                        'class'  => 'custom-control-input',
                                        'value' => '1'
                                    ];

                                    if($user['sms_survey_alert'] == '1')
                                    {
                                          $receive_alerts['checked'] = true;
                                    }

                                    echo form_checkbox($receive_alerts);
                                    echo form_label('Receive Survey Alerts', 'sms_receive_alerts', ['class' => 'custom-control-label']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-6"> 
                        <div class="row">
                            <?php echo form_label('Email Notifications'); ?>
                        </div>
                        <div class="row">
                             <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                    <?php
                                        $email_survey_completion = [
                                        'id'    => 'email_survey_completion',
                                        'class'  => 'custom-control-input',
                                        'value' => '1'
                                    ];

                                    if($user['email_survey_completion'] == '1')
                                    {
                                          $email_survey_completion['checked'] = true;
                                    }

                                    echo form_checkbox($email_survey_completion);
                                    echo form_label('Receive all survey completion', 'email_survey_completion', ['class' => 'custom-control-label']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                    <?php
                                        $email_survey_alerts = [
                                        'id'    => 'email_survey_alerts',
                                        'class'  => 'custom-control-input',
                                        'value' => '1'
                                    ];

                                    if($user['email_survey_alert'] == '1')
                                    {
                                          $email_survey_alerts['checked'] = true;
                                    }


                                    echo form_checkbox($email_survey_alerts);
                                    echo form_label('Receive Survey Alerts', 'email_survey_alerts', ['class' => 'custom-control-label']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                <div class="card-footer">
                  <a href="<?php echo base_url('users/'); ?>" class="btn btn-warning float-right ">Close</a>
                </div>
            </div>
            <!-- /.card-body -->
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <?php echo form_close(); ?>

  </div>
<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- /.login-box -->
<?php echo view('scripts'); ?>
<script>
      $(document).on( 'click', '.delete-user', function () {
        var record_id = $(this).attr("data-id");

        Swal.fire({
            title: 'Are you sure want to Delete?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
            location.href='<?php echo base_url('users/delete/') ?>' + '/'+record_id;
        }
    })
    });
</script>

<script>
    $(function () {
        $('#parent_user,#school_destination').hide();
        $("input,select,checkbox,textarea").prop("disabled", true);

        var base_url = $('#base_url').val();

      

        var parent_user_type= $(".gps option:selected").val();

            if(parent_user_type == '3')
            {
                  $('.parent_user_type').text('Reporting RTC');
            }
            else if(parent_user_type == '5')
            {
                  $('.parent_user_type').text('Reporting LTC');
            }
            else if(parent_user_type == '7')
            {
                  $('.parent_user_type').text('Reporting OAC');
            }

        var user_group_type = $('#group_id').val();
        if(user_group_type != '')
        {
                  if(user_group_type == "7")
                  {
                        //get parent user id
                        hidden_parent_id = $('#hidden_parent_user').val();
                        fill_user_oas(6,hidden_parent_id);
                        $('.oas_district').hide();
                        $("#district").rules("remove", "required");
                  }

                  if(user_group_type == "2" || user_group_type == "4" || user_group_type == "6")
                  {
                      load_districts();
                  }

                  if(user_group_type == "3" && $('#hidden_parent_user').val() != '')
                  {
                      fill_user('2',$('#hidden_parent_user').val());
                  }

            if(user_group_type == "5" && $('#hidden_parent_user').val() != '')
            {
                fill_user('4',$('#hidden_parent_user').val());
            }
        }

        function fill_user(id,seletedUser='')
        {
            $('#parent_user').show();
            $("#district").prop("multiple",  "multiple");

            $.ajax({
                url: base_url+"/users/getusers/"+id,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    var option_list = '<option>--Select--</option>';
                    $.each(data, function(key,value) {
                        var selected ='';
                                    if(seletedUser == value.id)
                                    {
                                          selected ='selected';
                                    }
                        option_list += '<option value="'+value.id+'"'+selected+'>'+value.first_name+'</option>';
                    });
                    $('#parent_user_id').append(option_list);

                    //get parent id and load districts
                    $('#district').empty();
                              $.ajax({
                                      url: base_url+"/users/getuserdistricts/"+$('#parent_user_id').val(),
                                      method: 'GET',
                                      dataType: 'json',
                                      success: function (data) {
                                          var option_list = '';
                                              $.each(data, function(key,value) {
                                                  option_list += '<option value="'+value.id+'">'+value.district_name+'</option>';
                                              });
                                              $('#district').append(option_list);

                                              //ajax fetch selected
                                              userid = "<?php echo $user['userid']; ?>";
                                              $.ajax({
                                                          url: base_url+"/users/getuserdistricts/"+userid,
                                                          method: 'GET',
                                                          dataType: 'json',
                                                          success: function (data) {
                                                            var option_list = '';
                                                                $.each(data, function(key,value) {
                                                                    $("#district option[value='" + value.id + "']").prop("selected", true);
                                                                });
                                                          }
                                            });
                                      }
                          });
                }
            });
        }

        $('#parent_user_id').change(function(){ 
            callSchoolDestination($(this).val());

            if($('#group_id').val() == '3' || $('#group_id').val() == '5')
            {
                $('#district').empty();
                $.ajax({
                      url: base_url+"/users/getuserdistricts/"+$(this).val(),
                      method: 'GET',
                      dataType: 'json',
                      success: function (data) {
                            var option_list = '';
                            $.each(data, function(key,value) {
                                option_list += '<option value="'+value.id+'">'+value.district_name+'</option>';
                            });
                            $('#district').append(option_list);
                      }
                });
            }
        });

        function callSchoolDestination(id)
        {
            $('#school_destination').show();   
            $('#school_destination_text').text('');   
            $.ajax({
                  url: base_url+"/users/getschooldestination/"+id,
                  method: 'GET',
                  dataType: 'json',
                  success: function (data) {
                      $('#school_destination_text').text(data[0].school_name);
                  }
            });
        }

        function fill_user_oas(id,seletedUser='')
        {
          $('#parent_user').show();
           
            $.ajax({
              url: base_url+"/users/getusers/"+id,
              method: 'GET',
              dataType: 'json',
              success: function (data) {
                  var option_list = '<option>--Select--</option>';
                  $.each(data, function(key,value) {
                      var selected ='';
                      if(seletedUser == value.id)
                      {
                          selected ='selected';
                      }
                      option_list += '<option value="'+value.id+'"'+selected+'>'+value.first_name+'</option>';
                  });
                  $('#parent_user_id').append(option_list);
                  callSchoolDestination(seletedUser);
              }
            });
        }

        function load_districts()
      {
             //load districts here
              $('#district').empty();
                  $.ajax({
                          url: base_url+"/users/getalldistricts/",
                          method: 'GET',
                          dataType: 'json',
                          success: function (data) {
                              console.log(data);
                              var option_list = '';
                                  $.each(data, function(key,value) {
                                      option_list += '<option value="'+value.id+'">'+value.district_name+'</option>';
                                  });
                                  $('#district').append(option_list);

                                  //ajax fetch selected
                                  userid = "<?php echo $user['userid']; ?>";
                                  $.ajax({
                                              url: base_url+"/users/getuserdistricts/"+userid,
                                              method: 'GET',
                                              dataType: 'json',
                                              success: function (data) {
                                                var option_list = '';
                                                    $.each(data, function(key,value) {
                                                        $("#district option[value='" + value.id + "']").prop("selected", true);
                                                    });
                                              }
                                });
                          }
            });
      }


});
</script>

<?php
echo view('footer'); ?>