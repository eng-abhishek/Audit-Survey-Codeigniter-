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
                    <h1>School Districts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">School Districts</li>
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
                   
                        <!-- /.card-header -->
<div class="container card-header">
                        <div class="row">
                        <div class="col-sm-8">           
<div class="row">
<!-- <div class="col-lg-1 card-title">List</div> -->   
                             <div class="col-lg-4">
                             <input type="text" name="value" id="search_value" class="form-control" placeholder="Search">
                             </div>
                             <div class="col-lg-4">
                                 <div class="input-group">
                                       <select id="listsearchfilter" class="form-control" style="width:40%">
                                       <option value="null">Filter by</option>
                                       <option value="district_name">District Name</option>
                                       <option value="district_code">District Code</option>
                                       <option value="billing_address1">Address</option>
                                       <option value="state_name">State</option>
                                       <option value="city">City</option>
                                       <option value="zipcode">Zip</option>
                                       <option value="district_url">School Website</option>
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
                            <a href="<?php echo base_url('districts/add'); ?>" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New</a> 
                         </div>
                        </div>
                    </div>

                        <div class="card-body">
                            <table id="ListofDistrictDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>District Name</th>
                                        <th>District Code</th>
                                        <th>Billing Address</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Zip</th>
                                        <th>School Website</th>
                                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="getListOfDistrict">
                                <?php if($district_list){
                                foreach ($district_list as $key => $value){
                                ?>
                                <tr>
                                <td><?php echo $key + 1;?></td>
                                <td><?php echo $value->district_name;?></td>
                                <td><?php echo $value->district_code;?></td>
                                <td><?php echo $value->billing_address1;?></td>
                                <td><?php echo $value->state_name;?></td> 
                                <td><?php echo $value->city;?></td>
                                <td><?php echo $value->zipcode;?></td> 
                                <td><?php echo $value->district_url;?></td> 
                                <td>
                                <a href="<?php echo base_url('districts/edit/' . base64_encode($value->id));?>"><i class="fas fa-edit"></i></a>
                                 <a href="<?php echo base_url('districts/view/' . base64_encode($value->id));?>"><i class="fas fa-eye"></i></a>
                                <a href="#" data-id="<?php echo base64_encode($value->id);?>" class="delete-destrict"><i class="fas fa-trash"></i></a>
                                </td> 
                                </tr>
                               <?php } } ?>
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
<?php echo view('scripts'); ?>

<!-- Page specific script -->
<script>
$(document).on("click",".del_template",function(){
var id = $(this).attr("data-id");
var url="<?php echo base_url();?>";
var r=confirm("Do you want to delete this?")
if (r==true)
window.location = url+"/districts/delete/"+id;
else
return false;
});

$(function(){
$('#ListofDistrictDataTable').DataTable({
    searching: false,
    "processing": true,
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
url:'<?php echo base_url('districts/listofDistrict');?>',
method:'POST',
processing:true,
data:{col_name:col_name,input_filter:input_filter},
success:function(data){
if(data==''){ 
$('#getListOfDistrict').html("<tr><td colspan='13' style='text-align:center'>No matching records found</td></tr>");
}else{
$('#getListOfDistrict').html(data);
}
}
})
});
    $(document).on('click', '.delete-destrict', function () {
        var record_id = $(this).attr("data-id");

        Swal.fire({
            title: 'Are you sure want to Delete?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
            location.href='<?php echo base_url('districts/delete/') ?>' + '/'+record_id;
        }
    })
    });
</script>
<?php echo view('footer'); ?>
</body>

</html>