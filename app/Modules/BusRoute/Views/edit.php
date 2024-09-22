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
                              <h1>Edit Bus Route</h1>
                        </div>
                        <div class="col-sm-6">
                              <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url('bus-routes'); ?>">Bus Routes</a></li>
                                    <li class="breadcrumb-item active">Edit</li>
                              </ol>
                        </div>
                  </div>
            </div><!-- /.container-fluid -->
      </section>
      
<section class="content">
<div class="container-fluid">
<div class="row">
              <div class="col-sm-3"></div>  
              <div class="col-sm-3"></div>
              <div class="col-sm-3"></div>
 <div class="col-sm-3">           
<div class="custom-control custom-switch" style="font-size:15px;float:right;margin-right:30px">
<input type="checkbox" class="busRouteStatus custom-control-input listaction" name="busRoute_status" id="busRoute_status" data-rid="<?php echo $record->id;?>" onchange="checkbusStatus('<?php echo $record->id;?>')" <?php if($record->is_active=='1'){ echo"checked";}else{ }?>>
<label class="custom-control-label" for="busRoute_status"></label>
<input type="text" name="rsid" id="rsid" hidden value="<?php echo $record->is_active;?>">
<font id="textBusStatus"><?php if($record->is_active=='1'){ echo"Active";}else{ echo"Inactive";}?></font>                       
<a href="#" class="delete-burRoute" data-id="<?php echo base64_encode($record->id);?>" style="font-size:18px;color:#ff7d31;padding-left:20px"><i class="fa fa-trash"></i></a>  
</div>
</div>
</div><br>
                            <form method="post" action="<?php echo base_url('bus-routes/edit/'.service('request')->uri->getSegment(3));?>" enctype="multipart/form-data" class="busRouteForm">
                                <div class="col-sm-12">             
                                <div class="col-sm-6">
                                    <?php echo form_label('Route Managed By', 'incharge_id'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-6">
                                <select class="custom-select form-control" id="userId" name="incharge_id" onchange="getUserDetails(this.value)" required="">
                                <option value=""> select user </option>
                                <?php foreach ($users as $key => $user) {
                                ?>
                               <option <?php if($user->id==$record->coordinator_id){ echo"selected";} ?> value="<?php echo $user->id;?>"> <?php echo $user->username; ?></option>
                               <?php } ?>
                                </select>  
                                <input type="text" name="txtuserId" value="<?php echo $record->coordinator_id;?>" id="txtuserId" hidden="">     
                               
                                </div>
                            </div>

                    <br>     
                    <div class="col-12 userDetailsPanel" style="display:none">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">LTC Details</h3>
                        </div>
                        <div class="card-body">
                        <div id="userDetails"></div>
                        </div>
                    </div>
                    </div>

                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Bus Route Detail</h3>
                        </div>
                        <div class="card-body">

                        <div class="form-group row">             
                        <div class="col-sm-3">
                                    <?php echo form_label('LTC - Route Name', 'ltc_route_name'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $ltc_route_name = [
                                        'name'  => 'ltc_route_name',
                                        'id'    => 'ltc_route_name',
                                        'class'  => 'form-control',
                                        'value' => set_value('ltc_route_name',$record->route_name?: ''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($ltc_route_name);
                                    ?>
                                    
                                </div>
                           </div>

                            <div class="form-group row">
                             <div class="col-sm-3">
                                    <?php echo form_label('From Date', 'from_date'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $name = [
                                        'type'=>'datetime-local',
                                        'name'  => 'from_date',
                                        'id'    => 'from_date',
                                        'class'  => 'form-control',
                                        'value' => 'value="2018-02-25T19:24:23"',
                                        'required' => TRUE
                                            ];
                                    echo form_input($name);
                                    ?>
                              
                                </div>
                             </div>

                             <div class="form-group row">
                             <div class="col-sm-3">
                                    <?php echo form_label('To Date', 'to_date'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $name = [
                                        'type'=>'datetime-local',
                                        'name'  => 'to_date',
                                        'id'    => 'to_date',
                                        'class'  => 'form-control',
                                        'value' =>'value="2018-05-25T19:24:23"',
                                        'required' => TRUE
                                            ];
                                    echo form_input($name);
                                    ?>
                                </div>
                            </div>
                        
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Shift', 'shift'); ?>
                                </div>
                                <div class="input-group col-sm-9">
                                  <div class="col-sm-4">
                                <?php echo form_label('Morning', 'morning'); ?>
                                <input type="checkbox" <?php if(in_array('morning',explode(',',$record->shift))){ echo"checked";}?> name="shift[]" value="morning">
                                </div>
                                <div class="col-sm-4">
                                <?php echo form_label('Afternoon', 'afternoon'); ?>  
                                <input <?php if(in_array('afternoon',explode(',',$record->shift))){ echo"checked";}?> type="checkbox" name="shift[]" value="afternoon">  
                                </div>
                                <div class="col-sm-4">
                                <?php echo form_label('Outside Hours', 'outside_hours'); ?>
                                <input <?php if(in_array('outside_hours',explode(',',$record->shift))){ echo"checked";}?> type="checkbox" name="shift[]" value="outside_hours">
                                </div> 
                                </div>
                             </div>
 
                            <div class="form-group row">
                                <div class="col-sm-3">
                                <?php echo form_label('Is this route outsourced to RTC', 'is_this_route_outsourced'); ?>
                                 <apan class="text-danger">*</apan>
                                </div>
                                 <div class="input-group col-sm-9"> 
                                <input type="checkbox" name="is_this_route_outsourced" id="is_this_route_outsourced" <?php if(!empty($record->oac_route_name)){ echo"checked";}?> value="is_this_route_outsourced" onclick="route_outsourced()">
                                <input type="text" name="chkRTC" id="chkRTC" hidden value="<?php if(!empty($record->oac_route_name)){ echo"1";} else{ echo"0";}?>">
                                 </div>
                            </div>

                            <div id="is_this_route_outsourced_fields" style="display:none">
                            <div class="form-group row">
                             <div class="col-sm-3">
                                    <?php echo form_label('RTC Route Name', 'rtc_route_name'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $name = [
                                        'type'=>'text',
                                        'name'  => 'rtc_route_name',
                                        'id'    => 'rtc_route_name',
                                        'class'  => 'form-control',
                                        'value' => set_value('rtc_route_name',$record->oac_route_name? :''),
                                        'required' => TRUE
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                             </div>
                           </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Type of Vehicle', 'vehicle_type'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $options = ['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'];
                                    $vehicle_type = [
                                        'name'  => 'vehicle_type',
                                        'id'    => 'vehicle_type',
                                        'class'  => 'custom-select',
                                        'value' => set_value('vehicle_type'),
                                        'required' => TRUE
                                    ];
                                    echo form_dropdown($vehicle_type,$options,$record->vehicle_type ? :'');
                                    ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Bus Company', 'bus_company_id'); ?>
                                     <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $busCompanyOptions = [];
                                    foreach ($busCompanies as $busCompany) {
                                        $busCompanyOptions[$busCompany->id] = $busCompany->company_name;
                                    }
                                    $busCMPoptions = $busCompanyOptions;
                                    $bus_company_id = [
                                        'name'  => 'bus_company_id',
                                        'id'    => 'bus_company_id',
                                        'class'  => 'custom-select',
                                        
                                        'value' => set_value('bus_company_id'),
                                        'required' => TRUE
                                    ];
                                    echo form_dropdown($bus_company_id,$busCMPoptions,$record->bus_company_id ? :'');
                                    ?>
                                 
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                <?php echo form_label('School Destination', 'school_destination_id'); ?>
                                 <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                <select name="school_destination_id[]" class="custom-select" multiple="" id="school_destination_id" required="">
                                <?php foreach ($schoolDestination as $key => $schoolDestinations) {
                                 ?>
                                <option <?php if(in_array($schoolDestinations->id,$getSelectedDestination)){ echo"selected";} ?> value="<?php echo $schoolDestinations->id;?>"><?php echo $schoolDestinations->school_name;?></option> 
                                <?php }
                                ?>
                                </select>
                                </div>
                             </div>
                             <div class="form-group row">
                             <div class="col-sm-3">
                                    <?php echo form_label('Tag Survey', 'tag_survey'); ?>
                                </div>
                                <div class="col-sm-9">
<select name="survey_id[]" class="custom-select form-control" id="survey_id" multiple="">
  <option value=""> select survey</option>
  <?php foreach($surveyList as $surveyListData){
  ?>
  <option <?php if(in_array($surveyListData['id'],$arrRouteSurveyId)){ echo"selected";}?> value="<?php echo $surveyListData['id'];?>"><?php echo $surveyListData['name'];?></option>  
  <?php }?>
</select>
                                </div>
                             </div>
<hr>
<br>
                            <div class="form-group row">
                            <div class="col-sm-3">
                            <?php echo form_label('Student Data Import', 'student_data_import'); ?>
                            </div>
                            <div class="input-group col-sm-3"> 
                            <input type="file" name="uploadFile">
                            </div>
                            
                            <div class="input-group col-sm-3"> 
                            <a href="<?php echo base_url('bus-routes/exportStudentData');?>"><input type="button" name="btnimport" class="btn btn-dark" value="Download Template"></a>
                            </div>
                            </div>
                            <hr> 
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                  <div class="form-group">
            <?php echo form_submit('submit', 'Update', ['class' => 'btn btn-info ']); ?>
         </div> 
              </form>
            </div>
            <!-- /.row -->
          
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
<?php echo view('scripts');
echo view('footer'); ?>
<script type="text/javascript">
$(function(){
$('.userDetailsPanel').show(); 
// $("#busRoute_status").bootstrapSwitch();
setTimeout(function(){
getUserDetails($('#txtuserId').val());     
checkRtc(); 
},1000)
 });

    $(".busRouteForm").validate({
      rules:{
      ltc_route_name:{
      required:true,
      },
      incharge_id:{
      required:true,  
      },
      from_date:{
      required:true,
      },
      to_date:{
      required:true,
      },
      vehicle_type:{
      required:true,  
      },
      bus_company_id:{
      required:true,  
      },
      'school_destination_id[]':{
      required:true,
      },
      'shift[]':{
      required:true,
      maxlength:1
      },
      },
      messages:{
      ltc_route_name:{
      required:"Please enter LTC route name",
      },
     'shift[]':{
      required:'Please checked any shift',
      },
      'school_destination_id[]':{
      required:'Please select school destination',  
      },
      bus_company_id:{
      required:"Please select bus company",  
      },
      vehicle_type:{
      required:"Please select vehicle type",  
      },
      to_date:{
      required:"Please enter to date",  
      },
      from_date:{
      required:"Please enter from date",  
      },
      incharge_id:{
      required:"Please select route managed by",  
      }
      },
    });

jQuery.validator.addMethod("greaterThan", 
function(value, element, params) {

    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val()) 
        || (Number(value) > Number($(params).val())); 
},'Must be greater than {0}.');

$("#to_date").rules('add', {greaterThan:"#from_date"});
   
function checkRtc(){
if($('#chkRTC').val()=='1'){
$('#is_this_route_outsourced_fields').show();
}
}

function route_outsourced(){
if($('#is_this_route_outsourced').is(':checked')){
$('#is_this_route_outsourced_fields').show(); 
}else{
$('#is_this_route_outsourced_fields').hide();  
}
}

 function getUserDetails(id){
if(id){
$.ajax({
url:"<?php echo base_url('bus-routes/get-user-detail-for-busRoute'); ?>",
method:'POST',
data:{id:id},
success:function(data){
$('.userDetailsPanel').show();    
$('#userDetails').html(data);    

}    
})
}else{
$('.userDetailsPanel').hide();
}
}

function checkbusStatus(id){
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
          url: "<?php echo base_url('bus-routes/update_status'); ?>",
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

 $(document).on('click', '.delete-burRoute', function (){
        var record_id = $(this).attr("data-id");
        Swal.fire({
            title: 'Are you sure want to Delete?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
            location.href='<?php echo base_url('bus-routes/delete') ?>' + '/'+record_id;
        }
    })
    });
</script>