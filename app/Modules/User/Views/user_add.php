<?php
echo view('header');
echo view('sidebar');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php echo form_open(base_url('users/add'), ['class' => 'userForm']); ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add User</h1>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo form_label('User Type', 'group_id',['class' => 'field_required']); ?></label>
                            <?php
                                $options = ['' => '--Select--'];
                                foreach ($groups as $group) {
                                    if($group->id != 1)
                                    {
                                        $options[$group->id] = $group->code . ' - ' . $group->name;
                                    }
                                }
                                $group_id = [
                                    'name'  => 'group_id',
                                    'id'    => 'group_id',
                                    'class'  => 'custom-select',
                                    'options' => $options,
                                    'value' => set_value('group_id'),
                                    'required' => TRUE
                                ];

                                if($current_user->group_id == '4')
                                {
                                    $group_id['selected'] = '5';
                                    $group_id['disabled'] = TRUE;
                                }
                                else if($current_user->group_id == '2')
                                {
                                    $group_id['selected'] = '3';
                                    $group_id['disabled'] = TRUE;
                                }
                                else if($current_user->group_id == '6')
                                {
                                    $group_id['selected'] = '7';
                                    $group_id['disabled'] = TRUE;
                                }

                                echo form_dropdown($group_id);
                         ?>
                    </div>

                    <div class="form-group only_oac">
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
                            echo form_dropdown('school_destination_id',$school_destination_opt,'',$attr);
                        ?>                
                    </div>
                    
                    <?php
                        if($current_user->group_id == '4' || $current_user->group_id == '2' || $current_user->group_id == '6')
                        {   
                        ?>
                        <div class="form-group ">
                            <?php 
                                echo form_label('Reporting '.$currentGroups[0]->code, 'parent_user');
                                 $parent_user_id = [
                                            'name'    => 'parent_user_id',
                                            'id'      => 'parent_user_id',
                                            'class'  => 'form-control',
                                            'type'    => 'text',
                                            'required' => TRUE,
                                            'data-uid' => $current_user->id,
                                            'value' => $current_user->first_name,
                                            'disabled' => 'disabled' 
                                         ];
                                        echo form_input($parent_user_id);
                            ?>                
                        </div>
                        <?php
                        }
                        else
                        {
                        ?>
                        <div class="form-group " id="parent_user">
                            <?php 
                                echo form_label('Reporting User', 'parent_user',['class' => 'parent_user_type']);
                            ?>   
                            <select class="form-control" name="parent_user_id" id="parent_user_id">

                            </select>             
                        </div>
                        <?php
                        }
                        ?>

                  
                        <?php
                            if($current_user->group_id == '4' || $current_user->group_id == '2')
                            {   
                            ?>
                            <div class="form-group">
                                <?php echo form_label('Districts', 'name',['class' => 'field_required']); ?>
                           
                                <?php
                                $options = [];
                             
                                $other_attrs = ["id" => "district", "class" => "form-control", "multiple" => "multiple"];

                                echo form_dropdown('districts[]', $options, 'large', $other_attrs);
                                ?>
                            </div>
                            <?php
                            }
                            else
                            {  
                            ?>

                            <div class="form-group  oas_district">
                                <?php echo form_label('Districts', 'name',['class' => 'field_required']); ?>
                            
                                <?php
                                $options = [];
                             
                                $other_attrs = ["id" => "district", "class" => "form-control", "multiple" => "multiple"];

                                echo form_dropdown('districts[]', $options, 'large', $other_attrs);
                                ?>
                            </div>

                        <?php } ?>
                   
                </div>
            </div>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="button-switch float-left">
                        <input type="checkbox" name="active" value="1" id="switch-green" class="switch" checked />
                        <label for="switch-blue" class="lbl-off">inactive</label>
                        <label for="switch-blue" class="lbl-on">active</label>
                      </div>
                      <div class="delete-icon float-right"><a href="#">
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

     <section class="content only_rtc">
      <div class="container-fluid">
        <div class="card form-box">
            <div class="card-header">
              <h3 class="card-title">Regional Transportation Authority</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group only_rtc">
                        <?php 
                            echo form_label('Name of Organization', 'name',['class' => 'field_required']); 
                             $organization_name = [
                                'name'  => 'organization_name',
                                'id'    => 'organization_name',
                                'class'  => 'form-control',
                                'value' => set_value('organization_name')
                            ];
                            echo form_input($organization_name);
                        ?>                
                    </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group only_rtc">
                            <?php 
                                echo form_label('Billing Address 1', 'billing_address_1',['class' => 'field_required']); 
                                $billing_address_1 = [
                                    'name'  => 'billing_address_1',
                                    'id'    => 'billing_address_1',
                                    'class'  => 'form-control',
                                    'rows' => 2,
                                    'value' => set_value('billing_address_1')
                                ];
                                echo form_textarea($billing_address_1);
                            ?>                
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group only_rtc">
                        <?php 
                            echo form_label('Billing Address 2', 'billing_address_2');
                            $billing_address_2 = [
                                'name'  => 'billing_address_2',
                                'id'    => 'billing_address_2',
                                'class'  => 'form-control',
                                'rows' => 2,
                                'value' => set_value('billing_address_2')
                            ];
                            echo form_textarea($billing_address_2);
                        ?>                
                        </div>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group only_rtc">
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
                            echo form_dropdown('billing_state', $options,'',$attr);
                        ?>                
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group only_rtc">
                        <?php 
                            echo form_label('City', 'city',['class' => 'field_required']);
                            $billing_city = [
                                'name'    => 'billing_city',
                                'id'      => 'billing_city',
                                'class'  => 'form-control',
                                'type'    => 'text'
                            ];
                            echo form_input($billing_city);
                        ?>                
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group only_rtc">
                        <?php 
                            echo form_label('Billing Zipcode', 'billing_zipcode',['class' => 'field_required']);
                            $billing_zipcode = [
                                'name'    => 'billing_zipcode',
                                'id'      => 'billing_zipcode',
                                'class'  => 'form-control',
                                'type'    => 'text',
                                'required' => TRUE
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
                                'name'    => 'website_url',
                                'id'      => 'website_url',
                                'class'  => 'form-control',
                                'type'    => 'url',
                                'value' => set_value('website_url')
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
                                    'name'  => 'name',
                                    'id'    => 'name',
                                    'class'  => 'form-control',
                                    'value' => set_value('name'),
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
                                    'name'  => 'last_name',
                                    'id'    => 'last_name',
                                    'class'  => 'form-control',
                                    'value' => set_value('last_name'),
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
                                    'name'    => 'title_role',
                                    'id'      => 'title_role',
                                    'class'  => 'form-control',
                                    'type'    => 'text',                          
                                    'value' => set_value('title_role'),
                                    'required' => TRUE
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
                                    'name'  => 'address',
                                    'id'    => 'address',
                                    'class'  => 'form-control',
                                    'rows' => 2,
                                    'value' => set_value('address'),
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
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                          <?php 
                            echo form_label('City', 'city',['class' => 'field_required']); 
                            $city = [
                                'name'    => 'city',
                                'id'      => 'city',
                                'class'  => 'form-control',
                                'type'    => 'text',
                                'value' => set_value('city'),
                                'required' => TRUE
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
                                    'class' => 'form-control',
                                    'onChange' => 'load_cities();'
                                ];
                                echo form_dropdown('state', $options,'',$attr);
                            ?>            
                          </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <?php 
                            echo form_label('Zipcode', 'zipcode',['class' => 'field_required']); 
                            $zipcode = [
                                'name'    => 'zipcode',
                                'id'      => 'zipcode',
                                'class'  => 'form-control',
                                'type'    => 'text',
                                'value' => set_value('zipcode'),
                                'required' => TRUE
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
                                    'name'  => 'phone',
                                    'id'    => 'phone',
                                    'class'  => 'form-control',
                                    'value' => set_value('phone'),
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
                                        'name'  => 'email',
                                        'id'    => 'email',
                                        'class'  => 'form-control',
                                        'value' => set_value('email'),
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
                                    'name'  => 'fax',
                                    'id'    => 'fax',
                                    'class'  => 'form-control',
                                    'value' => set_value('fax'),
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
                                            'name'  => 'sms_survey_completion',
                                            'id'    => 'sms_survey_completion',
                                            'class'  => 'custom-control-input',
                                            'value' => '1'
                                        ];
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
                                            'name'  => 'sms_receive_alerts',
                                            'id'    => 'sms_receive_alerts',
                                            'class'  => 'custom-control-input',
                                            'value' => '1'
                                        ];
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
                            </div>
                            <div class="col-sm-6">
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
                <div class="card-footer">
                    <?php echo form_submit('submit', 'Submit', ['class' => 'btn btn-warning float-right ']); ?>
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
<script src="<?php echo base_url('assets/js/user/user.js'); ?>"></script>
<?php echo view('footer'); ?>