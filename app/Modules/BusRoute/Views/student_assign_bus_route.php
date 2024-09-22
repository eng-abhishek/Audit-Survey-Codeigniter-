<?php
echo view('header');
echo view('sidebar');
?>
<style type="text/css">
.dataTables_length{
 display:none;   
}    
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assign Bus Route</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Assign Bus Route</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                     <div class="card card-secondary">
                        <div class="card-header">
                        <h3 class="card-title">Student Assign To The School Bus Route</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Special Transportation</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <?php 
                                  $allAsssignStu=array();
                                  foreach($listOfStudentBusRoute as $key => $listOfStudentBusRouteVal){ 
                                  $allAsssignStu[]=$listOfStudentBusRouteVal->student_id;
                                    ?>
                                <tr>   
                                <td><?php echo $listOfStudentBusRouteVal->student_id;?></td>
                                <td><?php echo $listOfStudentBusRouteVal->first_name.' '.$listOfStudentBusRouteVal->last_name;?></td>
                                <td><?php if($listOfStudentBusRouteVal->special_transportations=='1'){
                                if($listOfStudentBusRouteVal->flg_bus_nurse=='1'){ echo "Bus Nurse<br>"; }else{ }

                                if($listOfStudentBusRouteVal->flg_bus_wheelchair=='1'){ echo "Bus Wheelchair<br>"; }else{ }

                                if($listOfStudentBusRouteVal->flg_bus_specialreqs=='1'){ echo "Bus Specialreqs<br>"; }else{ }

                                if($listOfStudentBusRouteVal->flg_bus_aide=='1'){ echo "Bus Aids<br>"; }else{ }

                                if($listOfStudentBusRouteVal->flg_car_seat_required=='1'){ echo "car Seat Required<br>"; }else{ }

                                if($listOfStudentBusRouteVal->flg_harness_required=='1'){ echo "Harness Required<br>"; }else{ }  

                                if($listOfStudentBusRouteVal->flg_harness_required=='1'){ echo "Harness Required<br>"; }else{ }  

                                if($listOfStudentBusRouteVal->flg_bus_specialreqs_desc=='1'){ echo "Bus Special Req Des<br>"; }else{ }

                                if($listOfStudentBusRouteVal->flg_type_of_chair=='1'){ echo "Type of chair<br>"; }else{ }

                                if($listOfStudentBusRouteVal->flg_carharness_type_size=='1'){ echo "Carharness Type Size<br>"; }else{ }
                                }else{ echo"N/A";}?></td>
                                <td><a href="javascript:void(0)" onclick="removeVidarthiFromRoute('<?php echo $listOfStudentBusRouteVal->student_id;?>','<?php echo $listOfStudentBusRouteVal->route_id?>')"><i class="fa fa-remove" style="color:black;"></i></a></td>
                                </tr>
                                <?php  }
                                ?>  
                              </tbody>
                            </table>
                        </div>
                       </div>

                        <div class="card card-secondary">
                        <div class="card-header">
                        <h3 class="card-title">List Of Student</h3>
                        </div>
                        <div class="card-body">
                            <table id="busRouteListDataTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Sending District Name</th>
                                <th>School Destination</th>
                                <th>Special Transportation</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php 
                                foreach($listOfAllStudent as $key => $listOfAllStudentData){
                                if(in_array($listOfAllStudentData->student_id,$allAsssignStu)){
                                }else{
                                ?>
                                <tr>   
                                <td><?php echo $listOfAllStudentData->student_id;?></td>
                                <td><?php echo $listOfAllStudentData->first_name.' '.$listOfAllStudentData->last_name;?></td>
                                <td><?php echo $listOfAllStudentData->district_name;?></td>
                                <td><?php echo $listOfAllStudentData->school_name;?></td>
                                <td><?php if($listOfAllStudentData->special_transportations=='1'){
                                  if($listOfAllStudentData->flg_bus_nurse=='1'){ echo "Bus Nurse<br>"; }else{ }
                               
                                  if($listOfAllStudentData->flg_bus_wheelchair=='1'){ echo "Bus Wheelchair<br>"; }else{ }

                                  if($listOfAllStudentData->flg_bus_specialreqs=='1'){ echo "Bus Specialreqs<br>"; }else{ }
                               
                                  if($listOfAllStudentData->flg_bus_aide=='1'){ echo "Bus Aids<br>"; }else{ }

                                  if($listOfAllStudentData->flg_car_seat_required=='1'){ echo "car Seat Required<br>"; }else{ }

                                  if($listOfAllStudentData->flg_harness_required=='1'){ echo "Harness Required<br>"; }else{ }  

                                  if($listOfAllStudentData->flg_harness_required=='1'){ echo "Harness Required<br>"; }else{ }  

                                  if($listOfAllStudentData->flg_bus_specialreqs_desc=='1'){ echo "Bus Special Req Des<br>"; }else{ }
                                 
                                 if($listOfAllStudentData->flg_type_of_chair=='1'){ echo "Type of chair<br>"; }else{ }

                                 if($listOfAllStudentData->flg_carharness_type_size=='1'){ echo "Carharness Type Size<br>"; }else{ }
                                 }else{ echo"N/A";}?></td> 
                                <td>
                                <?php $routeId=service('request')->uri->getSegment(3);
                                $destID=$listOfAllStudentData->destination_id;
                                $SID=$listOfAllStudentData->student_id;
                                ?>
                                <a href="javascript:void(0)" onclick="assignBusRoute('<?php echo $routeId;?>','<?php echo $destID;?>','<?php echo $SID;?>')"><i class="fa fa-plus" style="color:black;"></i></a>
                                </td>
                                </tr>
                                <?php } 
                                  }?>
                               </tbody>
                              </table>
                            </div>
                           </div>
                     <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
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
<?php echo view('scripts');
echo view('footer'); ?>
<script type="text/javascript">
    $(function() {
    $("#busRouteListDataTable").DataTable({
      "ordering": false,   
    });
    })
function assignBusRoute(busRuteID,destID,sid){
$.ajax({
url:'<?php echo base_url('bus-routes/assigin-bus-route-to-student');?>',
method:'POST',
data:{busRuteID:busRuteID,destID:destID,sid:sid},
success:function(data){
location.reload();
 }
 });
}

function removeVidarthiFromRoute(id,rid){
$.ajax({
url:'<?php echo base_url('bus-routes/remove-assigin-bus-route-to-student');?>',
method:'POST',
data:{id:id,rid:rid},
success:function(data){
location.reload();
 }
 });
}

//console.log('busRouteID'+busRuteID,'destID'+destID,'sid'+sid);

</script>
</body>
</html>