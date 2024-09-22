<?php
echo view('header');
echo view('sidebar');
?>
<style type="text/css">
.card-header{
border-bottom:none;    
}
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
                    <h1>Bus Routes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Bus Routes</li>
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
                        <div class="card-header">
                        <div class="container">
                        <div class="row">
                        <div class="col-sm-8">
                            
<div class="row">
<!-- <div class="col-lg-1 card-title">List</div>    -->
                            <div class="col-lg-4">
                                   <input type="text" name="search_value" id="search_value" class="form-control" placeholder="Search">
                            </div>
                            <div class="col-lg-4">
                                 <div class="input-group">
                                     <select id="listsearchfilter" class="form-control" style="width:40%">
                                        <option value="null">Filter by</option>
                                        <option value="route_name">Route Name</option>
                                        <option value="start_date">Start Date</option>
                                        <option value="end_date">End Date</option>
                                        <option value="shift">Shift</option>
                                        <option value="vehicle_type">Type Of Vehicle</option>
                                        <option value="school_destination">School Destination</option>
                                        <option value="company_name">Company Name</option>
                                        <!-- <option value="is_active">Status</option> -->
                                      </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                              <span class="input-group-btn">
                                    <button type="button" class="btn btn-secondary" id="searchdt"><i class="glyphicon glyphicon-search"></i>Search</button>
                              </span>
                            </div>
                        </div></div>

                        <div class="col-sm-4">
                            <a href="<?php echo base_url('bus-routes/add'); ?>" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New</a> 
                         </div>
                        </div></div>
                        
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="busrtcListDataTable" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Route Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Shift</th>
                                        <th>Type of Vehicle</th>
                                        <th>School Destination</th>
                                        <th>Bus Company</th>
                                        <th>View Students</th>
                                        <th>Status</th>
                                        <th>Preformed Survey</th>
                                        <th>Survey with Alert</th>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    </tr>
                                </thead>
                            <tbody id="input_filter">
                            <?php 
                            foreach ($listOfBusRoute as $key=>$value){
                            //foreach ($listRecord as $value){
                            ?>   
                            <tr>
                            <td><?php echo $key+1; ?></td>
                            <td><?php echo $value['route_name']; ?></td>
                            <td><?php echo $value['start_date']; ?></td>
                            <td><?php echo $value['end_date']; ?></td>
                            <td><?php echo $value['shift']; ?></td>
                            <td><?php echo $value['vehicle_type']; ?></td>
                            <td><?php echo $value['sch_name']; ?></td>
                            <td><?php echo $value['company_name'];?></td>
                            <td><a style="color:black" href="<?php echo base_url('bus-routes/view-student/'.base64_encode($value['route_id']));?>">view students</a></td>
                             <td>
                             <?php
                             if($value['is_active'] == '1'){
                              $valtext="Active";
                              }else{
                              $valtext="Inactive";
                              }
                             echo"<p id='textStatus".$value['route_id']."'>".$valtext."</p>";
                             ?>
                            </td>
                            <td><?php echo $value['total_survey'];?></td>
                            <td><?php echo $value['alert_survey'];?></td>
                            <td>
                             <?php
                             if($value['is_active'] == '1'){
                              $val="checked";
                              }else{
                              $val="";
                              }
                             ?> 
                             <div class="custom-control custom-switch">
                            <input type="checkbox" class="busRouteStatus custom-control-input listaction" name="status<?php echo $value['route_id']; ?>" id="status<?php echo $value['route_id']; ?>" <?php echo $val;?> data-rid="<?php echo $value['route_id'];?>">
                            <label class="custom-control-label" for="status<?php echo $value['route_id']; ?>"></label>
                             <input type="text" name="rid<?php echo $value['route_id'];?>" id="rid<?php echo $value['route_id'];?>" hidden value="<?php echo $value['is_active'];?>">

                             <a href="<?php echo base_url('bus-routes/edit/' . base64_encode($value['route_id'])); ?>"><i class="fas fa-edit"></i></a>
                            <a href="<?php echo base_url('bus-routes/view/' . base64_encode($value['route_id'])); ?>"><i class="far fa-eye"></i></a>
                            <a href="#" data-id="<?php echo base64_encode($value['route_id']);?>" class="delete-busroute"><i class="fas fa-trash"></i></a>
                            </div>     
                            
                            </td></tr>            
                            <?php } ?>
                              </tbody>
                            </table>
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
<!-- Page specific script -->
<script type="text/javascript">
$(function(){
$("#status").bootstrapSwitch();
$('#busrtcListDataTable').DataTable({
    searching: false,
    paging: true,
    info: false,
    "ordering": false,
    "aaSorting": []
});
$('.dataTables_length').hide();
});

$('#searchdt').on('click',function(){
var col_name=$('#listsearchfilter').val();
var input_filter=$('#search_value').val();
$.ajax({
url:'<?php echo base_url('bus-routes/listofRoute');?>',
method:'POST',
data:{col_name:col_name,input_filter:input_filter},
success:function(data){
  console.log(data);
if(data==''){
$('#input_filter').html("<tr><td colspan='13' style='text-align:center'>No matching records found</td></tr>");
}else{
$('#input_filter').html(data);  
}  
}
})
});

 $(document).on('click', '.delete-busroute', function (){
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

 $(document).on( 'change', '.busRouteStatus', function () {
        //call here
        var status;  
        id = $(this).attr("data-rid");

    if($('#status'+id).is(":checked")){
       status='1';
    }else{
       status='0';  
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
            console.log(id);
            $('#rid'+id).val(status);
            if(status==1){
            $('#textStatus'+id).html('Active');
            }else{
            $('#textStatus'+id).html('Inactive');
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
      var datastatus=$('#rid'+id).val();
      if(datastatus=='1'){
      $('#status'+id).prop('checked',true);
      }else{
      $('#status'+id).prop('checked',false);
      }

      }
      })

    }); 


</script>
</body>
</html>