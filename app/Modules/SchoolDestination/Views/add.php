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
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>New School Destination</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('school-destination'); ?>">School Destination</a></li>
                        <li class="breadcrumb-item active">New</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <?php echo form_open(base_url('school-destination/add'), ['class' => 'destination_validateForm']); ?>

<div class="row">
              <div class="col-sm-3"></div>  
                <div class="col-sm-3"></div>  
                         <div class="col-sm-3"></div>  
              <div class="col-sm-3">
                     
 <div class="custom-control custom-switch" style="float:right;margin-right:30px">
<input type="checkbox" name="destination_status" class="custom-control-input listaction" value="1" checked="checked" id="district_status" onChange="checkStatus()">
 <label class="custom-control-label" for="district_status"></label>
 <font id="textStatus">Active</font>
 </div>
          </div>
          </div><br>

             <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">School Destination Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.school_name'), 'school_name'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $school_name = [
                                        'name'  => 'school_name',
                                        'id'    => 'school_name',
                                        'class'  => 'form-control',
                                        'value' => set_value('school_name'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($school_name);
                                    ?>
                                   
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.address1'), 'address1'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $address1 = [
                                        'name'  => 'address1',
                                        'id'    => 'address1',
                                        'class'  => 'form-control',
                                        'rows' => 2,
                                        'value' => set_value('address1'),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($address1);
                                    ?>
                                  
                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.address2'), 'address2'); ?>
                              <apan class="text-danger">*</apan>
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
                                <?php echo form_label(lang('district.city'), 'city'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                <input type="text" name="city" class="form-control" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.state'), 'state'); ?>
                                  <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                               <select name="state" style="color:black" id="state" class="form-control" onchange="getCityData(this.value)" required="">
                                <option value="">select state</option>
                                <?php if($getState){ foreach($getState as $getStateData){ ?>
                                <option value="<?php echo $getStateData->id;?>"><?php echo $getStateData->state_name;?></option>
                                <?php } }?>
                                </select>
                                </div>
                            </div>



                            <div class="form-group row">
                                <div class="col-sm-3">
                                <?php echo form_label(lang('destination.zipcode'), 'zipcode'); ?>
                                 <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $zipcode = [
                                        'name'  => 'zipcode',
                                        'id'    => 'zipcode',
                                        'class'  => 'form-control',
                                        'value' => set_value('zipcode'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($zipcode);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.offic_phone_no'), 'office_phone'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $office_phone = [
                                        'name'  => 'office_phone',
                                        'id'    => 'office_phone',
                                        'class'  => 'form-control',
                                        'value' => set_value('office_phone'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($office_phone);
                                    ?>
                                </div>
                            </div>

                          <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.offic_email'), 'office_email'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $office_email = [
                                        'name'  => 'office_email',
                                        'id'    => 'office_email',
                                        'type'  => 'email',
                                        'class'  => 'form-control',
                                        'value' => set_value('office_email'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($office_email);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.offic_fax'), 'office_fax'); ?>
                                   <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $office_fax = [
                                        'name'  => 'office_fax',
                                        'id'    => 'office_fax',
                                        'class'  => 'form-control',
                                        'value' => set_value('office_fax'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($office_fax);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.active_route'), 'active_routes'); ?>
                                </div>
                                <div class="col-sm-9">
                                <select name="active_routes" style="color:black" class="form-control" required="">
                                <option value="">select route</option>
                                <?php if($allRoute){
                                foreach ($allRoute as $activeRoute){ ?>
                                <option value="<?php echo $activeRoute->id;?>"><?php echo $activeRoute->route_name;?></option>   
                                <?php } } ?>
                                </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.school_code'), 'school_code'); ?>
                                 <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $school_code = [
                                        'name'  => 'school_code',
                                        'id'    => 'school_code',
                                        'class'  => 'form-control',
                                        'value' => set_value('school_code'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($school_code);
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.website_url'), 'website_url'); ?>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                        $website_url = [
                                        'name'  => 'website_url',
                                        'id'    => 'website_url',
                                        'type'  =>  'url',
                                        'class'  => 'form-control',
                                        'value' => set_value('website_url'),
                                        
                                    ];
                                    echo form_input($website_url);
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
                <?php echo form_submit('submit', 'Create', ['class' => 'btn btn-info ']); ?>
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


<script type="text/javascript">
    $(function(){
   $(".destination_validateForm").validate({
    rules:{
     school_name:{
     required:true,
     maxlength:200,
     minlength:2, 
      },
    address1:{
    required:true,
    maxlength:300,
    minlength:20,
    },
    address2:{
    required:true,
    maxlength:300,
    minlength:20,
    },
    state:{
    required:true,
    },
    city:{
    required:true,
    },
    zipcode:{
    maxlength:60,
    minlength:2,
    number:true,
    },
    office_phone:{
    number:true,
    maxlength:12,
    minlength:10,
    },
    office_email:{
    email:true,
    },
    office_fax:{
    required:true, 
    maxlength:200,
    minlength:2,
    number:true,
    },
    active_routes:{
    required:true,    
    },
    active_routes:{
    required:true,    
    },
    school_code:{
    required:true,
    maxlength:50,    
    },
    website_url:{
    maxlength:500,
    url:true,
    }
    },
    messages:{
    school_name:{
     required:"Please enter school name",
      },
    address1:{
    required:"Please enter address 1",
    },
    address2:{
    required:"Please enter address 2",
    },
    state:{
    required:"Please select state",
    },
    city:{
    required:"Please select city",
    },
    zipcode:{
    required:"Please enter zipcode",
    },
    office_phone:{
    required:"Please enter office phone no",
    },
    office_email:{
    required:"Please enter office email",
    },
    office_fax:{
    required:"Please enter office fax",
    },
    active_routes:{
    required:"Please select active route",   
    },
    school_code:{
    required:"Please enter school code",   
    },
    website_url:{
    required:"Please enter website url",
    }
    }
    });  
    })

   function getCityData(id){
      $.ajax({
      url: "<?php echo base_url('school-destination/getCityData')?>",
      method:'POST',
      data:{id:id},
      success:function(data){
      $('#getCity').html(data);
      }
      })
} 
function checkStatus(){
if($('#district_status').is(':checked')){
$('#district_status').attr('value','1');
$('#textStatus').html('Active');
}else{
$('#district_status').attr('value','0');      
$('#textStatus').html('Inactive');
}
}
</script>
<?php echo view('footer'); ?>
