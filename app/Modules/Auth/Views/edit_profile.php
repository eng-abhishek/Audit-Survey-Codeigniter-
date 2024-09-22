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
                              <h1>Manage Profile</h1>
                        </div>
                        <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('users'); ?>">Users</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                              </ol>
                        </div>
                  </div>
            </div><!-- /.container-fluid -->
      </section>
      <?php

      		$disabled = TRUE;
        if($user->group_id == '2') {
        	$disabled = FALSE;
        } 

      ?>
      <section class="content">
            <div class="container-fluid">
                  <?php echo form_open(base_url('edit-profile'), ['class' => 'validateForm3 manageprofile','id' => 'manageprofile']); ?>

                
                  <div class="row">
                        <div class="col-6">
                              <div class="card card-primary">
                                    <div class="card-header">
                                          <h3 class="card-title">Personal Detail</h3>
                                    </div>
                                    <div class="card-body">

                                         <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('User Type', 'user_type'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                        echo $_SESSION['user_type'] ;
                                                      ?>
                                                </div>
                                          </div>
                                          <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('Districts', 'districts'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                      $distrcit = '';
                                                        foreach($districts as $key => $value)
                                                        {
                                                            $distrcit .= $value['district_name'].",";
                                                        }

                                                        echo rtrim($distrcit, ',');
                                                      ?>
                                                </div>
                                          </div>
                                          <?php if($_SESSION['user_type'] == ROLE_RTS || $_SESSION['user_type'] == ROLE_LTS || $_SESSION['user_type'] == ROLE_OAS){ ?>
                                           <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('Coordinator Name'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                        echo $parent_user[0]['first_name']. " ".$parent_user[0]['last_name'] ;
                                                      ?>
                                                </div>
                                          </div>

                                           <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('Coordinator Contact'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                        echo $parent_user[0]['phone'];
                                                      ?>
                                                </div>
                                          </div>
                                        <?php } ?>

                                        <?php
                                        if($_SESSION['user_type'] == ROLE_OAC || $_SESSION['user_type'] == ROLE_OAS)
                                        {
                                        ?>
                                            <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('School Destination'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                        echo $school_destination[0]['school_name'];
                                                      ?>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                         <!--  <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('User Group', 'group_id'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                      $options = [];
                                                      foreach ($groups as $group) {
                                                            $options[$group['id']] = $group['code'] . ' - ' . $group['name'];
                                                      }
                                                      $group_id = [
                                                            'name'  => 'group_id',
                                                            'id'    => 'group_id',
                                                            'class'  => 'custom-select',
                                                            'options' => $options,
                                                            'value' => set_value('group_id', $currentGroups[0]->id),
                                                            'required' => TRUE,
                                                            'disabled'  => TRUE
                                                      ];
                                                      echo form_dropdown($group_id, true, $currentGroups[0]->id);
                                                      ?>
                                                </div>
                                          </div> -->

                        <?php if($user->group_id == '2') { ?>
                              <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Name of Organization', 'name',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $organization_name = [
                                        'name'  => 'organization_name',
                                        'id'    => 'organization_name',
                                        'class'  => 'form-control',
                                        'value' => set_value('organization_name', $user->organization_name ?: '')
                                    ];
                                    echo form_input($organization_name);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Billing Address 1', 'billing_address_1',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $billing_address_1 = [
                                        'name'  => 'billing_address_1',
                                        'id'    => 'billing_address_1',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('billing_address_1', $user->billing_address_1 ?: '')
                                    ];
                                    echo form_textarea($billing_address_1);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Billing Address 2', 'billing_address_2'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $billing_address_2 = [
                                        'name'  => 'billing_address_2',
                                        'id'    => 'billing_address_2',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('billing_address_2', $user->billing_address_2 ?: '')
                                    ];
                                    echo form_textarea($billing_address_2);
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
                                            'id' => 'billing_state',
                                            'class' => 'form-control'
                                        ];
                                        echo form_dropdown('billing_state', $options,$user->billing_state,$attr);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('City', 'city',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $billing_city = [
                                        'name'    => 'billing_city',
                                        'id'      => 'billing_city',
                                        'class'  => 'form-control',
                                        'type'    => 'text',
                                        'value' => set_value('billing_city', $user->billing_city ?: '')
                                    ];
                                    echo form_input($billing_city);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group row only_rtc">
                                <div class="col-sm-3">
                                    <?php echo form_label('Billing Zipcode', 'billing_zipcode',['class' => 'field_required']); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $billing_zipcode = [
                                        'name'    => 'billing_zipcode',
                                        'id'      => 'billing_zipcode',
                                        'class'  => 'form-control',
                                        'type'    => 'text',
                                        'value' => set_value('billing_zipcode', $user->billing_zipcode ?: '')
                                    ];
                                    echo form_input($billing_zipcode);
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Website URL', 'website_url'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                     $website_url = [
                                        'name'    => 'website_url',
                                        'id'      => 'website_url',
                                        'class'  => 'form-control',
                                        'type'    => 'url',
                                        'value' => set_value('website_url', $user->website_url ?: '')
                                    ];
                                    echo form_input($website_url);
                                    ?>
                                </div>
                            </div>

                            <?php } ?>


                                          <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('First Name', 'name'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                      $name = [
                                                            'name'  => 'first_name',
                                                            'id'    => 'first_name',
                                                            'class'  => 'form-control',
                                                            'value' => set_value('name', $user->first_name ?: ''),
                                                            'required' => TRUE,
                                                            'disabled'  => $disabled
                                                      ];
                                                      echo form_input($name);
                                                      ?>
                                                </div>
                                          </div>
                                          <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('Last Name', 'name'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                      $name = [
                                                            'name'  => 'last_name',
                                                            'id'    => 'last_name',
                                                            'class'  => 'form-control',
                                                            'value' => set_value('name', $user->last_name ?: 'N/A'),
                                                            'required' => TRUE,
                                                            'disabled'  => $disabled
                                                      ];
                                                      echo form_input($name);
                                                      ?>
                                                </div>
                                          </div>
                                           <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label('Title / Role', 'name'); ?>
                                                </div>
                                                <div class="col-sm-9">
                                                      <?php
                                                      $name = [
                                                            'name'  => 'title',
                                                            'id'    => 'title',
                                                            'class'  => 'form-control',
                                                            'value' => set_value('name', $user->title_role ?: 'N/A'),
                                                            'disabled'  => $disabled
                                                      ];
                                                      echo form_input($name);
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
                                                    'value' => set_value('address', $user->address ?: ''),
                                                    'required' => TRUE,
                                                    'disabled'  => $disabled
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
											    'value' => set_value('office_address', $user->office_address2 ?: ''),
											    'disabled'  => $disabled
											];
											echo form_textarea($office_address);
											?>
											</div>
										</div>
                                    </div>
                                    <!-- /.card-body -->
                              </div>
                              <!-- /.card -->
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
			                                            'disabled'  => $disabled
			                                        ];
			                                        echo form_dropdown('state', $options,$user->state,$attr);
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
			                                        'type'    => 'text',
			                                        'value' => set_value('city', $user->city ?: ''),
			                                        'disabled'  => $disabled
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
			                                        'type'    => 'text',
			                                        'value' => set_value('zipcode', $user->zipcode ?: ''),
			                                        'disabled'  => $disabled
			                                    ];
			                                    echo form_input($zipcode);
			                                    ?>
			                                </div>
			                            </div>
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
                                                            'value' => set_value('email', $user->email ?: ''),
                                                      ];
                                                      echo form_input($email);
                                                      ?>
                                                </div>
                                          </div>
			                             <div class="form-group row">
			                                <div class="col-sm-3">
			                                    <?php echo form_label('Mobile Number', 'phone',['class' => 'field_required']); ?>
			                                </div>
			                                <div class="col-sm-9">
			                                    <?php
			                                    $phone = [
			                                        'name'  => 'phone',
			                                        'id'    => 'phone',
			                                        'class'  => 'form-control',
			                                        'value' => set_value('phone', $user->phone ?: ''),
			                                    ];
			                                    echo form_input($phone);
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
				                                        'value' => set_value('ext', $user->extension ?: ''),
				                                    ];
				                                    echo form_input($ext);
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
				                                        'value' => set_value('fax', $user->fax ?: ''),
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

                                    if($user->sms_survey_completion == '1')
                                    {
                                          $sms_survey_completion['checked'] = true;
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

                                    if($user->sms_survey_alert == '1')
                                    {
                                          $receive_alerts['checked'] = true;
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

                                    if($user->email_survey_completion == '1')
                                    {
                                          $email_survey_completion['checked'] = true;
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
                                        'value' => '1'
                                    ];

                                    if($user->email_survey_alert == '1')
                                    {
                                          $email_survey_alerts['checked'] = true;
                                    }


                                    echo form_checkbox($email_survey_alerts);
                                    echo form_label('Receive Survey Alerts', 'email_survey_alerts', ['class' => 'custom-control-label']); ?>
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
                        <?php echo form_submit('submit', lang('Auth.edit_user_submit_btn'), ['class' => 'btn btn-info ']); ?>
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
<?php echo view('scripts');  ?>


<?php  if($user->group_id == '2') { ?>
    <script>
         $(document).ready(function(){
            $(".manageprofile :input").prop("disabled", false);
        });
    </script>
        
<?php } ?>

<?php echo view('footer'); ?>