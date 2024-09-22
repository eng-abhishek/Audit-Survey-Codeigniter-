<?php
echo view('header');
echo view('sidebar');
?>
<style>

#userListDataTable_filter { display: none; }

.custom-control-input:checked~.custom-control-label::before {
    color: #fff;
    border-color: #2bad49;
    background-color: #28a745;
    box-shadow: none;
}

div.dataTables_wrapper div.dataTables_length select {
    width: 40%;
    display: inline-block;
}

#userListDataTable_length { display: none; }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
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
                            <div class="container card-header">
                            <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="value" id="search_value" class="form-control" style="width:60%" placeholder="Search">
                                    </div>
                                       
                                </div>  
                                 <div class="col-lg-4">
                                     <div class="input-group">
                                            <select id="listsearchfilter" class="form-control" style="width:40%">
                                               <option value="0">Filter By</option>
                                               <option value="first_name">Name</option>
                                               <option value="code">User Type</option>
                                               <option value="title_role">Title</option>
                                               <option value="district_name">District</option>
                                               <option value="email">Email</option>
                                               <option value="phone">Phone</option>
                                               <option value="active">Status</option>

                                            </select>
                                     </div>
                                </div>
                              
                                <div class="col-lg-2">
                                  <span class="input-group-btn">
                                         <button class="btn btn-secondary" id="searchdt"><i class="glyphicon glyphicon-search"></i>Search</button>
                                  </span>
                                </div>
                              </div>
                             </div>

                            <div class="col-sm-4">
                                <a href="<?php echo base_url('users/add'); ?>" class="btn btn-warning float-right"><i class="fas fa-plus"></i> Add User</a>
                             </div>
                            </div></div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="userListDataTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>User type</th>
                                            <th>District</th>
                                            <th>Title / Role</th>
                                            <th>Address</th>
                                            <th>Email id</th>
                                            <th>Contact No</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
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
<?php echo view('scripts');  ?>
<!-- Page specific script -->
<script>
    $(function() {

        table = $('#userListDataTable').DataTable({ 
            processing: true,
            serverSide: true,
            order: [], //init datatable not ordering
            ordering: false,
            "bInfo" : false,
            ajax: {
                url: "<?php echo base_url('users/ajaxDatatables')?>",
                method: 'POST',
                data: function (d) {
                    d.search_value = $('#search_value').val();
                    d.listsearchfilter = $('#listsearchfilter').val();
                }
            },
            columns: [
                { "data": "no" },
                { "data": "name" },
                { "data": "user_type"},
                { "data": "districtname" },
                { "data": "title" },
                { "data": "address" },
                { "data": "email"},
                { "data": "phone" },
                { "data": "active" },
                { "data": "action" },
            ],
           
        });

         $('#searchdt').click(function(event) {
            table.ajax.reload();
         });
    });

    $(document).on( 'click', '.delete-user', function () {
        var record_id = $(this).attr("data-id");
        Swal.fire({
            title: 'Are you sure want to Delete?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
        }).then((result) => {
        if (result.isConfirmed) {
            location.href='<?php echo base_url('users/delete/') ?>' + '/'+record_id;
        }
    })
    });

    $('#listsearchfilter').change(function(){
        if($(this).val() == '0')
        {
            $('#search_value').val('');
            table.ajax.reload();
        }
    });

    $(document).on( 'change', '.listaction', function () {
        //call here
        var status;  
        id = $(this).attr("data-uid");

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
                url: "<?php echo base_url('users/update_status'); ?>",
                data: 'status='+status+'&id='+id, 
                success: function(data){  
                    if(data == 1)
                    {
                        Swal.fire('Status Updated');
                    }
                    table.ajax.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                }       
            });
            }
            else
            {
                table.ajax.reload();
            }
        })
    });
</script>
<?php echo view('footer'); ?>
