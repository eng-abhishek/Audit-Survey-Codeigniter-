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
  .color-black{
   color:black;   
  }  
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>New Bus Route</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('bus-routes'); ?>">Bus Routes</a></li>
                        <li class="breadcrumb-item active">New</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
        <div class="container-fluid">
    <form method="post" action="<?php echo base_url('bus-routes/add');?>" enctype="multipart/form-data" class="busRouteForm">
                
     <div class="row">
              <div class="col-sm-3"></div>  
                <div class="col-sm-3"></div>  
                         <div class="col-sm-3"></div>  
              <div class="col-sm-3">
                     
 <div class="custom-control custom-switch" style="float:right;margin-right:30px">
<input type="checkbox" name="busRoute_status" class="custom-control-input listaction" value="1" checked="checked" id="district_status" onChange="checkStatus()">
 <label class="custom-control-label" for="district_status"></label>
 <font id="textStatus">Active</font>
 </div>
          </div>
          </div><br>           
                                <div class="col-sm-12">             
                                <div class="col-sm-6">
                                <?php echo form_label('Route Managed By', 'incharge_id'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $inchargeOptions = [];
                                    $inchargeOptions[''] ='select user';
                                    foreach ($users as $user){
                                        $inchargeOptions[$user->id] = $user->username;
                                    }
                                    $incharge_id = [
                                        'name'  => 'incharge_id',
                                        'id'    => 'incharge_id',
                                        'class'  => 'custom-select form-control color-black',
                                        'options' => $inchargeOptions,
                                        'value' => set_value('incharge_id'),
                                        'required' => TRUE,
                                        'onChange'=>'getUserDetails(this.value)'
                                    ];
                                    echo form_dropdown($incharge_id);
                                    ?>
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
                                        'class'  => 'form-control color-black',
                                        'value' => set_value('ltc_route_name'),
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
                                        'class'  => 'form-control color-black',
                                        'value' => set_value('from_date'),
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
                                        'class'  => 'form-control color-black',
                                        'value' => set_value('to_date'),
                                        'required' => TRUE
                                    ];
                                    echo form_input($name);
                                    ?>
                                </div>
                              </div>
                        
                             <div class="form-group row">
                                <div class="col-sm-3">
                                    <?php echo form_label('Shift', 'shift'); ?>
                                    <apan class="text-danger">*</apan>
                                </div>
                                <div class="input-group col-sm-9">
                                  <div class="col-sm-4">
                                <?php echo form_label('Morning', 'morning'); ?>
                                <input type="checkbox" name="shift[]" value="morning">
                                </div>
                                <div class="col-sm-4">
                                <?php echo form_label('Afternoon', 'afternoon'); ?>  
                                <input type="checkbox" name="shift[]" value="afternoon">  
                                </div>
                                <div class="col-sm-4">
                                <?php echo form_label('Outside Hours', 'outside_hours'); ?>
                                <input type="checkbox" name="shift[]" value="outside_hours">
                                </div> 
                                </div>
                             </div>
 
                            <div class="form-group row">
                                <div class="col-sm-3">
                                <?php echo form_label('Is this route outsourced to RTC', 'is_this_route_outsourced'); ?>
                                </div>
                                 <div class="input-group col-sm-9"> 
                                <input type="checkbox" name="is_this_route_outsourced" id="is_this_route_outsourced" value="is_this_route_outsourced" onclick="route_outsourced()">
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
                                        'value' => set_value('rtc_route_name'),
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
                                    $vehicle_type = [
                                        'name'  => 'vehicle_type',
                                        'id'    => 'vehicle_type',
                                        'class'  => 'custom-select',
                                        'value' => set_value('vehicle_type'),
                                        'options'   => ['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'],
                                        'required' => TRUE
                                    ];
                                    echo form_dropdown($vehicle_type);
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
                                    $bus_company_id = [
                                        'name'  => 'bus_company_id',
                                        'id'    => 'bus_company_id',
                                        'class'  => 'custom-select',
                                        'options' => $busCompanyOptions,
                                        'value' => set_value('bus_company_id'),
                                        'required' => TRUE
                                    ];
                                    echo form_dropdown($bus_company_id);
                                    ?>
                                </div>
                            </div>
                             <div class="form-group row">
                                <div class="col-sm-3">
                                <?php echo form_label('School Destination', 'school_destination_id'); ?>
                                <apan class="text-danger">*</apan>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $schoolDestinationArr = [];
                                    foreach ($schoolDestination as $schoolDestinations) {
                                        $schoolDestinationArr[$schoolDestinations->id] = $schoolDestinations->school_name;
                                    }
                                    $school_destination_id = [
                                        'name'  => 'school_destination_id[]',
                                        'id'    => 'school_destination_id',
                                        'class'  => 'custom-select color-black',
                                        'multiple'=>'multiple',
                                        'options' => $schoolDestinationArr,
                                        'value' => set_value('school_destination_id'),
                                        'required' => TRUE
                                    ];
                                    echo form_dropdown($school_destination_id);
                                    ?>
                                  
                                </div>
                             </div>
                             <div class="form-group row">
                             <div class="col-sm-3">
                                    <?php echo form_label('Tag Survey', 'tag_survey'); ?>
                             
                                </div>
                                <div class="col-sm-9">
                                   <?php
                                  
                                    $surveyLists = [];
                                    $surveyLists[''] ='select user';
                                    foreach ($surveyList as $surveyListData){
                                        $surveyLists[$surveyListData['id']] = $surveyListData['name'];
                                    }
                                    $survey_id = [
                                        'name'  => 'survey_id[]',
                                        'id'    => 'survey_id',
                                        'class'  => 'custom-select form-control',
                                        'options' => $surveyLists,
                                        'multiple'=>'multiple',
                                        'value' => set_value('survey_id'),
                                                 ];
                                    echo form_dropdown($survey_id);
                                    ?>
                                 
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
                <?php echo form_submit('submit', 'Create', ['class' => 'btn btn-info ']); ?>
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
<?php echo view('scripts'); ?>
<script type="text/javascript">

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
</script>
