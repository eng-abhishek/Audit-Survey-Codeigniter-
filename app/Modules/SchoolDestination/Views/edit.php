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
                              <h1>Edit School Destination</h1>
                        </div>
                        <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('school-destination'); ?>">School Destination</a></li>
                                    <li class="breadcrumb-item active">Edit</li>
                              </ol>
                        </div>
                  </div>
            </div><!-- /.container-fluid -->
      </section>
      <section class="content">
            <div class="container-fluid">
<div class="row">
<div class="col-sm-3"><b>OAC Incharge :  <?php echo $OACIncharge;?></div></b>
<div class="col-sm-3"><b>Assigned Route :  <?php echo $total_route[0]->total_route;?></b></div>
<div class="col-sm-3"></div>
 <div class="col-sm-3">           
<div class="custom-control custom-switch" style="font-size:15px;float:right;margin-right:30px">
<input type="checkbox" class="busRouteStatus custom-control-input listaction" name="busRoute_status" id="busRoute_status" data-rid="<?php echo $record->id;?>" onchange="checkDestStatus('<?php echo $record->id;?>')" <?php if($record->is_active=='1'){ echo"checked";}else{ }?>>
<label class="custom-control-label" for="busRoute_status"></label>
<input type="text" name="rsid" id="rsid" hidden value="<?php echo $record->is_active;?>">
<font id="textBusStatus"><?php if($record->is_active=='1'){ echo"Active";}else{ echo"Inactive";}?></font>                       
<a href="#" class="delete-burRoute" data-id="<?php echo base64_encode($record->id);?>" style="font-size:18px;color:#ff7d31;padding-left:20px"><i class="fa fa-trash"></i></a>  
</div>
</div>
</div><br>

                  <?php echo form_open(base_url('school-destination/edit/' . service('request')->uri->getSegment(3)), ['class' => 'destination_validateForm']); ?>

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
                                <div class="col-sm-9">
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
                                        'value' => set_value('address1',$record->address1 ?: ''),
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
                                        'value' => set_value('address2',$record->address2 ?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_textarea($address2);
                                    ?>
                                   
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.city'), 'city'); ?>
                              <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                       
                                <input type="text" name="city" class="form-control" required="" value="<?php echo $record->city;?>"> 
                                </div>
                            </div>

                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label(lang('destination.state'), 'state'); ?>
                                  <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                
                               <select name="state" id="state" style="color:black" class="form-control" onchange="getCityData(this.value)" required="">
                                <option value="">select state</option>
                                <?php if($getState){ foreach($getState as $getStateData){ ?>
                                <option <?php if($getStateData->id==$record->state){ echo"selected"; }?> value="<?php echo $getStateData->id;?>"><?php echo $getStateData->state_name;?></option>
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
                                        'value' => set_value('zipcode',$record->zipcode ?: ''),
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
                                        'value' => set_value('office_phone',$record->office_phone ?: ''),
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
                                        'value' => set_value('office_email',$record->office_email ?: ''),
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
                                        'value' => set_value('office_fax',$record->office_fax ?: ''),
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
                                <option value="<?php echo $activeRoute->id;?>" <?php if($activeRoute->id==$record->active_routes){echo"selected";}?>><?php echo $activeRoute->route_name;?></option>   
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
                                        'value' => set_value('school_code',$record->school_code ?: ''),
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


function checkDestStatus(id){
if($('#busRoute_status').is(':checked')){
var status='1';
}else{
var status='0';
}

       Swal.fire({
            title: 'Are you sure want to change status?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
         $.ajax({
          type: "post",  
          url: "<?php echo base_url('school-destination/update_status'); ?>",
          data: 'status='+status+'&id='+id, 
          success: function(data){
           // console.log(id);
            $('#rsid').val(status);
            if($('#busRoute_status').is(':checked')){
            $('#textBusStatus').html('Active');
            }else{
            $('#textBusStatus').html('Inactive');
            }
            if(data == 1)
            {
            Swal.fire('Status Updated');
            }
           },
           error: function(XMLHttpRequest, textStatus, errorThrown) { 
          }       
      });
      }
      else
      {
      var datastatus=$('#rsid').val();
      console.log(datastatus);
      if(datastatus=='1'){
      $('#busRoute_status').prop('checked',true);
      }else{
      $('#busRoute_status').prop('checked',false);
      }
      }
      })
      }

 $(document).on( 'click', '.delete-burRoute', function (){
        var record_id = $(this).attr("data-id");
        Swal.fire({
            title: 'Are you sure want to Delete?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
            location.href='<?php echo base_url('school-destination/delete') ?>' + '/'+record_id;
        }
    })
    });


</script>    
<?php echo view('footer'); ?>
