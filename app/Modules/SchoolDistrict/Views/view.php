<?php
echo view('header');
echo view('sidebar');
?>
<style type="text/css">
.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #2bad49;
    background-color: #28a745;
    box-shadow: none; }
    .custom-switch .custom-control-input:disabled:checked~.custom-control-label::before{
    color: #fff;
    border-color: #2bad49;
    background-color: #28a745;
    box-shadow: none;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
            <div class="container-fluid">
                  <div class="row mb-2">
                        <div class="col-sm-6">
                              <h1>View District</h1>
                        </div>
                        <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('districts'); ?>">Districts</a></li>
                                    <li class="breadcrumb-item active">View</li>
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
<div class="custom-control custom-switch" style="font-size:15px;float:right;margin-right:30px">
<input type="checkbox" disabled class="custom-control-input listaction" name="district_status" id="district_status" data-rid="<?php echo $record->id;?>" onchange="checkDestrictStatus('<?php echo $record->id;?>')" <?php if($record->is_active=='1'){ echo"checked";}else{ }?>>
<label class="custom-control-label" for="district_status"></label>
<input type="text" name="rsid" id="rsid" hidden value="<?php echo $record->is_active;?>">
<font id="textDesStatus"><?php if($record->is_active=='1'){ echo"Active";}else{ echo"Inactive";}?></font> 
</div>
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
                                    <?php echo form_label(lang('district.state'), 'state'); ?>
                                       <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                <select name="state" id="state" class="form-control" onchange="getCityData(this.value)" required="">
                                <option value="">select state</option>
                                <?php if($getState){ foreach($getState as $getStateData){ ?>
                                <option <?php if($getStateData->id==$record->state){ echo"selected"; }?> value="<?php echo $getStateData->id;?>"><?php echo $getStateData->state_name;?></option>
                                <?php } }?>
                                </select>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                  <span class="fa fa-hotel"></span>
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
                                <select name="city" class="form-control" required="" id="getCity"><option value=""> select city </option>
                              <?php if($getAllCity){ foreach($getAllCity as $getAllCityData){ ?>
                                <option <?php if($getAllCityData->id==$record->city){ echo"selected"; }?> value="<?php echo $getAllCityData->id;?>"><?php echo $getAllCityData->city;?></option>
                                <?php } }?>  
                               </select>
                                <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa fa-home"></span>
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
               
                  <?php echo form_close(); ?>
            </div>
            <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php echo view('scripts');?>
<script type="text/javascript">

function getCityData(id){
      $.ajax({
      url: "<?php echo base_url('school-districts/getCityData')?>",
      method:'POST',
      data:{id:id},
      success:function(data){
      $('#getCity').html(data);
      }
      })
}
</script>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- /.login-box -->
<?php echo view('footer'); ?>