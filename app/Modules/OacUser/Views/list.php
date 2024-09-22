<?php
echo view('header');
echo view('sidebar',['unapproved_count' => $unapproved_count]);
?>
<style>
#oacApprovalList_filter { display: none; }
#loading{
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('//upload.wikimedia.org/wikipedia/commons/thumb/e/e5/Phi_fenomeni.gif/50px-Phi_fenomeni.gif') 
              50% 50% no-repeat rgb(249,249,249);
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>OAC Approvals</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">OAC Approvals</li>
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
                        <div class="container card-header">
                            <div class="row">
                            <div class="col-sm-8">
                                <div id="loading">
                                   <!--  <img src="<?php echo base_url('assets/images/loading.gif'); ?>" />   -->
                                </div>

                                 <div class="row">
                                 <div class="col-lg-1 card-title">List</div>   
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="value" id="search_value" class="form-control" style="width:60%" placeholder="Enter Filter Value">
                                    </div>
                                       
                                </div>
                                 <div class="col-lg-4">
                                     <div class="input-group">
                                        <select id="listsearchfilter" class="form-control" style="width:40%">
                                           <option value="0">Filter By</option>
                                           <option value="name">OAC Name</option>
                                           <option value="district_name">District</option>
                                           <option value="school_name">School Destination</option>
                                           <option value="registration_status">Status</option>
                                        </select>
                                     </div>
                                </div>
                                <div class="col-lg-2">
                                   <span class="input-group-btn">
                                        <button class="btn btn-secondary" id="search_approval"><i class="glyphicon glyphicon-search"></i>Search</button>
                                    </span>
                                </div>
                              </div>
                             </div>

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="oacApprovalList" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>OAC Name</th>
                                        <th>District</th>
                                        <th>School Destination</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>

<?php echo view('scripts');
echo view('footer'); ?>

<!-- Page specific script -->
<script>
    $(function() {
        $(function() {

              var $loading = $('#loading').hide();
               //Attach the event handler to any element
               $(document)
                 .ajaxStart(function () {
                    //ajax request went so show the loading image
                     $loading.show();
                 })
               .ajaxStop(function () {
                   //got response so hide the loading image
                    $loading.hide();
                });


            table = $('#oacApprovalList').DataTable({ 
                processing: true,
                serverSide: true,
                order: [], //init datatable not ordering
                ordering: false,
                ajax: {
                    url: "<?php echo base_url('oac-invites/ajaxDatatables') ?>",
                    data: function (d) {
                        d.search_value = $('#search_value').val();
                        d.listsearchfilter = $('#listsearchfilter').val();
                    }
                },
                columns: [
                    {data: 'no'},
                    {data: 'name'},
                    {data: 'district_name'},
                    {data: 'school_name'},
                    {data: 'registration_status'},
                    {data: 'action'}
                ],
               
            });

             $('#search_approval').click(function(event) {
                table.ajax.reload();
             });

        });

        $('#listsearchfilter').change(function(){
            if($(this).val() == '0')
            {
                $('#search_value').val('');
                table.ajax.reload();
            }
        });

        $(document).on( 'click', '.list_reject', function () {
			//call here
			var status;  
			id = $(this).attr("data-uid");

			Swal.fire({
			    title: 'Are you sure want to reject OAC approval?',
			    showDenyButton: true,
			    showCancelButton: false,
			    confirmButtonText: 'Yes',
			    denyButtonText: 'No',
			}).then((result) => {
			if (result.isConfirmed) {
			    $.ajax({
			        type: "post",  
			        url: "<?php echo base_url('oac-invites/reject'); ?>",
			        data: 'id='+id, 
			        success: function(data){  
                        var objJSON = JSON.parse(data);

                        if(objJSON.status == 'success')
                        {
                            Swal.fire('Rejected Successfully');
                        }
                        else
                        {
                            Swal.fire('Something went wrong please view and modify te record');
                        }
                        table.ajax.reload();
			        },
			        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        Swal.fire('Something went wrong please view and modify te record');
			        }       
			    });
			    }
			    else
			    {
			        table.ajax.reload();
			    }
			})
    	});


        $(document).on( 'click', '.list_approve', function () {
            //call here
            var status;  
            id = $(this).attr("data-uid");

            Swal.fire({
                title: 'Are you sure want to approve OAC approval?',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Yes',
                denyButtonText: 'No',
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",  
                    url: "<?php echo base_url('oac-invites/approve'); ?>",
                    data: 'id='+id, 
                    success: function(data){  
                        var objJSON = JSON.parse(data);

                        if(objJSON.status == 'success')
                        {
                            Swal.fire('Approved Successfully');
                        }
                        else
                        {
                            Swal.fire('Something went wrong please view and modify te record');
                        }
                        table.ajax.reload();
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        Swal.fire('Something went wrong please view and modify te record');
                    }       
                });
                }
                else
                {
                    table.ajax.reload();
                }
            })
        });


    });
</script>
</body>

</html>