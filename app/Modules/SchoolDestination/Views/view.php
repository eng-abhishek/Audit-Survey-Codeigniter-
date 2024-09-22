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
                              <h1>View School Destination</h1>
                        </div>
                        <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('school-destination'); ?>">School Destination</a></li>
                                    <li class="breadcrumb-item active">View</li>
                              </ol>
                        </div>
                  </div>
            </div><!-- /.container-fluid -->
      </section>

      <section class="content">
            <div class="container-fluid">
                  <?php echo form_open(base_url('school-destination/add/' . service('request')->uri->getSegment(3)), ['class' => 'destination_validateForm']); ?>


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

       <div class="row">
                        <div class="col-12">
                              <div class="card card-primary">
                                    <div class="card-header">
                                          <h3 class="card-title">School Detail</h3>
                                    </div>

                      <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.school_name'), 'school_name'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $school_name = [
                                        'name'  => 'school_name',
                                        'id'    => 'school_name',
                                        'class'  => 'form-control',
                                        'value' => set_value('school_name',$record->school_name ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($school_name);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.address1'), 'address1'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $address1 = [
                                        'name'  => 'address1',
                                        'id'    => 'address1',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('address1',$record->address1 ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($address1);
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
                                    <?php echo form_label(lang('destination.address2'), 'address2'); ?>
                              <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $address2 = [
                                        'name'  => 'address2',
                                        'id'    => 'address2',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('address2',$record->address2 ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($address2);
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
                                    <?php echo form_label(lang('destination.state'), 'state'); ?>
                                  <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                $state=['name'=>'state','class'=>'form-control','required'=>TRUE];     
                                $options = [
                                ''=>'State',
                                'up'  => 'Uttar Pradesh',
                                'maharashtra'    => 'Maharashtra',
                                'bihar'  => 'Bihar',
                                'west_bengal' => 'West Bengal',
                                'andhra_pradesh'=>'Andhra Pradesh',
                                ];
                                echo form_dropdown($state, $options,$record->state ?: '');
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
                                    <?php echo form_label(lang('destination.city'), 'city'); ?>
                              <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $city = [
                                        'name'  => 'city',
                                        'id'    => 'city',
                                        'class'  => 'form-control',
                                        'value' => set_value('city',$record->city ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($city);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.zipcode'), 'zipcode'); ?>
                                 <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $zipcode = [
                                        'name'  => 'zipcode',
                                        'id'    => 'zipcode',
                                        'class'  => 'form-control',
                                        'value' => set_value('zipcode',$record->zipcode ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($zipcode);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.offic_phone_no'), 'office_phone'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $office_phone = [
                                        'name'  => 'office_phone',
                                        'id'    => 'office_phone',
                                        'class'  => 'form-control',
                                        'value' => set_value('office_phone',$record->office_phone ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($office_phone);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                          <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.offic_email'), 'office_email'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $office_email = [
                                        'name'  => 'office_email',
                                        'id'    => 'office_email',
                                        'type'  => 'email',
                                        'class'  => 'form-control',
                                        'value' => set_value('office_email',$record->office_email ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($office_email);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.offic_fax'), 'office_fax'); ?>
                                   <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $office_fax = [
                                        'name'  => 'office_fax',
                                        'id'    => 'office_fax',
                                        'class'  => 'form-control',
                                        'value' => set_value('office_fax',$record->office_fax ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($office_fax);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                              <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.active_route'), 'active_routes'); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                $active_routes=['name'=>'active_routes','class'=>'form-control'];     
                                $opt_active_routes = [
                                ''=>'Routes',
                                '1'=> 'Rout 1',
                                '2'=> 'Rout 2',
                                '3'=> 'Rout 3',
                                '4'=> 'Rout 4',
                                '5'=> 'Rout 5',
                                ];
                                echo form_dropdown($active_routes, $opt_active_routes,$record->active_routes ?: '');
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.school_code'), 'school_code'); ?>
                                 <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                    $school_code = [
                                        'name'  => 'school_code',
                                        'id'    => 'school_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('school_code',$record->school_code ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($school_code);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.website_url'), 'website_url'); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                    <?php
                                        $website_url = [
                                        'name'  => 'website_url',
                                        'id'    => 'website_url',
                                        'type'  =>  'url',
                                        'class'  => 'form-control',
                                        'value' => set_value('website_url',$record->website_url ?: ''),
                                        
                                    ];
                                    echo form_input($website_url);
                                    ?>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-user"></span>
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
                  <!-- <div class="form-group">
                        <?php //echo form_submit('submit', 'Update', ['class' => 'btn btn-info ']); ?>
                  </div> -->
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
<?php echo view('footer'); ?>

<script type="text/javascript">
    $(function(){

   $(".destination_validateForm").validate({
    rules:{
    office_phone:{
      number:true,
      maxlength:12,
      minlength:10,
      },
       office_email:{
       email:true, 
      } 
     },
    
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorPlacement: function (error, element) {
            if (element.attr("id") == '') {
                error.insertAfter(element);
            } else {
                return false;
            }
        },
    });
        
    })
</script>    