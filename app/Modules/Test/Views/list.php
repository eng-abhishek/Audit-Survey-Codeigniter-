<?php
echo view('header');
echo view('sidebar');
?>
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
                        <div class="card-header">
                            <h3 class="card-title">List</h3>
                            <a href="<?php echo base_url('districts/add'); ?>" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New</a>
                        </div>
                        <!-- /.card-header -->

                        <div class="container">
                             <div class="col-lg-6">
                                 <div class="input-group">
                                    <select id="listsearchfilter" class="form-control" style="width:40%">
                                       <option value="null">Select</option>
                                       <option value="district_name">District Name</option>
                                       <option value="district_code">District Code</option>
                                       <option value="billing_address1">Address</option>
                                       <option value="state">State</option>
                                       <option value="city">City</option>
                                       <option value="zipcode">Zip</option>
                                       <option value="district_url">School Website</option>
                                      
                                      
                                    </select>
                                    <input type="text" name="value" id="search_value" class="form-control" style="width:60%" placeholder="Enter Filter Value">
                                    <span class="input-group-btn">
                                        <button class="btn btn-secondary" id="searchdt"><i class="glyphicon glyphicon-search"></i>Search</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="userListDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                               
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
    $(function() {
        var table_news = $('#userListDataTable').DataTable({
            "processing":true,
            "serverSide":true,  
            "order":[], 
            "ajax": {
                url : '<?php echo base_url("test/getListData"); ?>',
                type: "GET"  
            },
            "columnDefs":[  
                {  
                    "targets":[0],  
                    "orderable":false,
                },  
            ], 
        });

        // $("#table-news tbody").on('click', 'button', function() {
        //     var id = $(this).attr('data-id');
        //     if(this.name == "deleteButton") {
        //         var is_delete = confirm("Are your sure?");
        //         if(is_delete) {
        //             $.post('news/delete', {id: id}, function(result) {
        //                 $(".result").html(result);
        //                 table_news.ajax.reload();
        //             });
        //         }
        //     }
        // });
        
    });
    </script>





<script>
    var site_url = "<?php echo site_url(); ?>";
    $(document).ready( function () {


//          table = $('#userListDataTable').DataTable({ 
//             processing: true,
//             serverSide: true,
//             scrollY:true,
//             order: [], //init datatable not ordering
//             ajax: {
//                 url: "<?php echo base_url('test/getListData')?>",
//                 data: function (d) {
//                     d.search_value = $('#search_value').val();
//                     d.listsearchfilter = $('#listsearchfilter').val();
//                 }
//             },
//             columns: [
//             { data: "district_name" },
//             { data: "district_code" },
//             { data: "billing_address1" },
//             { data: "state" },
//             { data: "city" },
//             { data: "zipcode" },
//             { data: "district_url" },
//             { data: 'action'}
//             ],
//         });
// $('#searchdt').on('click',function(){
// table.ajax.reload();
// })


});

$(document).on("click",".del_template",function() {
var id = $(this).attr("data-id");
var url="<?php echo base_url();?>";
var r=confirm("Do you want to delete this?")
if (r==true)
window.location = url+"/districts/delete/"+id;
else
return false;
});
</script>
</body>

</html>