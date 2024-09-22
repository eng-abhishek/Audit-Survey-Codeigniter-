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
                    <h1>School Destination</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">School Destination</li>
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
                   <!--      <div class="card-header">
                            <h3 class="card-title">List</h3>
                            <a href="<?php echo base_url('school-destination/add'); ?>" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New</a>
                        </div> -->
                        <div class="container card-header">
                        <div class="row">
                        <div class="col-sm-8">
                        
                             <div class="row">
                           <!--   <div class="col-lg-1 card-title"></div>  -->  
                            <div class="col-lg-4">
                            <input type="text" name="value" id="search_value" class="form-control"  placeholder="Search">
                            </div>
                             <div class="col-lg-4">
                                 <div class="input-group">
                                       <select id="listsearchfilter" class="form-control" style="width:40%">
                                       <option value="null">Filter by</option>
                                       <option value="school_name">School Name</option>
                                       <option value="school_code">School Code</option>
                                       <option value="address1">Address</option>
                                       <option value="state_name">State</option>
                                       <option value="city">City</option>
                                       <option value="username">OAC Incharge</option>
                                       <option value="office_phone">Office Contact</option>
                                       <option value="office_email">Office Email</option> 
                                       <option value="route_name">Active Route</option>  
                                  <!--      <option value="is_active">Status</option>  -->
                                       </select>
                                 </div>
                            </div>
                           
                            <div class="col-lg-2">
                              <span class="input-group-btn">
                                    <button type="button" class="btn btn-secondary" id="searchdt"><i class="glyphicon glyphicon-search"></i>Search</button>
                              </span>
                            </div>
                          </div>
                         </div>

                        <div class="col-sm-4">
                            <a href="<?php echo base_url('school-destination/add'); ?>" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New</a> 
                         </div>
                        </div></div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="destinationDataTable" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                    <th>ID</th>
                                    <th>School Name</th>
                                    <th>School Code</th>
                                    <th>Address</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>OAC Incharge</th>
                                    <th>Office Contact</th>
                                    <th>Office Email</th>
                                    <th>Assigned Routes</th>
                                    <th>Status</th>
                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="getListOfDestination">
                                <?php 
                                foreach($records as $key => $value){
                                ?>
                                <tr>
                                <td><?php echo $key+1;?></td>
                                <td><?php echo $value->school_name;?></td>
                                <td><?php echo $value->school_code;?></td>
                                <td><?php echo $value->address1;?></td>
                                <td><?php echo $value->state_name;?></td>
                                <td><?php echo $value->city;?></td>
                                <td><?php echo $value->username;?></td>
                                
                                <td><?php echo $value->office_phone;?></td>
                                <td><?php echo $value->office_email;?></td>
                               
                                <td><?php echo $value->route_name;?></td>
                                <td><?php
                                if($value->is_active == '1'){
                                $val="checked";
                                }else{
                                $val="";
                                 }
                                ?>
                                <div class="custom-control custom-switch">
                                <input type="checkbox" class="destinationStatus custom-control-input" data-status="<?php echo $value->is_active;?>" name="status<?php echo $value->id;?>" id="status<?php echo $value->id;?>" <?php echo $val;?> data-did="<?php echo $value->id;?>">
                                <label class="custom-control-label" for="status<?php echo $value->id; ?>"></label>
                                <input type="text" name="sid<?php echo $value->id;?>" id="sid<?php echo $value->id;?>" hidden value="<?php echo $value->is_active;?>">
                                </div>
                               </td>
                               <td>
                            <a href="<?php echo base_url('school-destination/edit/' . base64_encode($value->id)); ?>"><i class="fas fa-edit"></i></a>
                            <a href="<?php echo base_url('school-destination/view/' . base64_encode($value->id)); ?>"><i class="far fa-eye"></i></a>
                            <a href="#" data-id="<?php echo base64_encode($value->id);?>" class="delete-destination"><i class="fas fa-trash"></i></a>    
                               </td>
                                </tr>
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
<script>
$('#searchdt').on('click',function(){
var col_name=$('#listsearchfilter').val();
var input_filter=$('#search_value').val();
$.ajax({
url:'<?php echo base_url('school-destination/listofDestination');?>',
method:'POST',
data:{col_name:col_name,input_filter:input_filter},
success:function(data){
if(data==''){
$('#getListOfDestination').html("<tr><td colspan='13' style='text-align:center'>No matching records found</td></tr>");
}else{
 $('#getListOfDestination').html(data); 
}  
}
})
});

$(function(){
$('#destinationDataTable').DataTable({
    searching: false,
    paging: true,
    info: false,
    ordering:false,
    processing: true,
    "scrollX": true,
    "ordering": false,
    "aaSorting": []
});
$('.dataTables_length').hide();
})

 $(document).on( 'click', '.delete-destination', function (){
        var record_id = $(this).attr("data-id");

        Swal.fire({
            title: 'Are you sure want to Delete?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
            location.href='<?php echo base_url('school-destination/delete/') ?>' + '/'+record_id;
        }
    })
    });

   $(document).on( 'change', '.destinationStatus', function () {
        //call here
        var status;  
        id = $(this).attr("data-did");

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
          url: "<?php echo base_url('school-destination/update_status'); ?>",
          data: 'status='+status+'&id='+id, 
          success: function(data){  
            console.log(id);
            $('#sid'+id).val(status);
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
      var datastatus=$('#sid'+id).val();
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