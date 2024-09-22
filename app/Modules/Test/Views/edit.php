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
                              <h1>Edit District</h1>
                        </div>
                        <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('school-districts'); ?>">Districts</a></li>
                                    <li class="breadcrumb-item active">Edit</li>
                              </ol>
                        </div>
                  </div>
            </div><!-- /.container-fluid -->
      </section>

      <section class="content">
            <div class="container-fluid">
                  <?php echo form_open(base_url('districts/edit/' . service('request')->uri->getSegment(3)), ['class' => 'validateForm']); ?>

<div class="row">
              <div class="col-sm-3"></div>  
                <div class="col-sm-3"></div>  
                         <div class="col-sm-3"></div>  
              <div class="col-sm-3">
              
                                <?php
                                $status = [
                                'name'    => 'district_status',
                                'id'      => 'district_status',
                                'class'  => 'form-control mb-5',
                                'type'    => 'checkbox',
                                'data-on-text' => 'Active',
                                'data-off-text' => 'Inactive',
                                'data-bootstrap-switch' => '',
                                'data-off-color' => 'danger',
                                'data-on-color' => 'success',
                                'onChange' => 'checkStatus();',
                                         ];
                       
                               if($record->is_active=='1'){ 
                                $status['checked']='checked';
                                 }else{ 
                                 }
                          
                            echo form_input($status);
                        ?>
                                           
                </div>
          </div><br>

                            <div class="col-12">
                              <div class="card card-primary">
                                    <div class="card-header">
                                          <h3 class="card-title">Districts</h3>
                                    </div>
                                    <div class="card-body">
                                         <div class="form-group row">
                                                <div class="col-sm-3">
                                                      <?php echo form_label(lang('district.district_name'), 'name'); ?>
                                                      <apan class="text-danger">*</apan>
                                                </div>
                                                <div class="input-group col-sm-9">
                                                      <?php
                                                      $name = [
                                                            'name'  => 'name',
                                                            'id'    => 'name',
                                                            'class'  => 'form-control',
                                                            'value' => set_value('name', $record->district_name ?: ''),
                                                            'required' => TRUE
                                                      ];
                                                      echo form_input($name);
                                                      ?>
                                                      <div class="input-group-append">
                                                            <div class="input-group-text">
                                                          <span class="fa fa-adjust"></span>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>

                                  <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.district_code'), 'district_code'); ?>
                                       <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $district_code = [
                                        'name'  => 'district_code',

                                        'id'    => 'district_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('district_code',$record->district_code ?:''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($district_code);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                        <span class="fa fa-laptop"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.web_url'), 'district_web_url'); ?>
                                       <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $district_web_url = [
                                        'name'  => 'district_web_url',
                                        'id'    => 'district_web_url',
                                        'type'=>'url',
                                        'class'  => 'form-control',
                                        'value' => set_value('district_web_url',$record->district_url ? : ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($district_web_url);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                                   <span class="fa fa-code"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Billing Address 1', 'billing_address'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $billing_address1 = [
                                        'name'  => 'billing_address_1',
                                        'id'    => 'billing_address_1',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value(lang('district.billing_address1'),$record->billing_address1 ? : ''),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($billing_address1);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-address-card"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.billing_address2'), 'billing_address_2'); ?>
                                    <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $billing_address2 = [
                                        'name'  => 'billing_address_2',
                                        'id'    => 'billing_address_2',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('billing_address_2',$record->billing_address2 ? : ''),
                                   
                                    ];
                                    echo form_textarea($billing_address2);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-address-card"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.city'), 'city'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $city = [
                                        'name'  => 'city',
                                        'id'    => 'city',
                                        'class'  => 'form-control',
                                        'value' => set_value('city',$record->city),
                                        'required' => TRUE
                                    ];
                                    echo form_input($city);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                             <span class="fa fa-home"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.state'), 'state'); ?>
                                       <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $state = [
                                        'name'  => 'state',
                                        'id'    => 'state',
                                        'class'  => 'form-control',
                                        'required' => TRUE
                                    ];
                                 $options = [
                                ''=>'State',
                                'up'  => 'Uttar Pradesh',
                                'maharashtra'    => 'Maharashtra',
                                'bihar'  => 'Bihar',
                                'west_bengal' => 'West Bengal',
                                'andhra_pradesh'=>'Andhra Pradesh',
                                ];
                                echo form_dropdown($state,$options,$record->state ? : '');
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                  <span class="fa fa-hotel"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                              <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('district.zip_code'), 'zip_code'); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $zip_code = [
                                        'name'  => 'zip_code',
                                        'id'    => 'zip_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('zip_code',$record->zipcode ? : ''),
                                 
                                    ];
                                    echo form_input($zip_code);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                             <span class="fa fa-info"></span>
                                        </div>
                                    </div>
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
                        <?php echo form_submit('submit', 'Update', ['class' => 'btn btn-info ']); ?>
                  </div>
                  <?php echo form_close(); ?>
            </div>
            <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
function checkStatus(){
if($('#district_status').is(':checked')){
$('#district_status').attr('value','1');
}else{
$('#district_status').attr('value','0');      
}
}  
</script>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- /.login-box -->
<?php echo view('scripts');
echo view('footer'); ?>