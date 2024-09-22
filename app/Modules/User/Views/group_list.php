<?php
echo view('header');
echo view('sidebar');
?>

<style>
#groupListDataTable_filter { display: none; }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Groups</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('users'); ?>">Users</a></li>
                        <li class="breadcrumb-item active">Groups</li>
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
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="groupListDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>User Group</th>
                                        <th>Is Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $record) { ?>
                                        <tr>
                                            <td><?php echo $record->name; ?></td>
                                            <td><?php echo $record->code; ?></td>
                                            <td><?php echo $record->is_admin==1 ? '<i class="fas fa-check-square text-success"></i>' : '<i class="fas fa-window-close text-danger"></i>'; ?></td>
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
    $(function() {
        $("#groupListDataTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [2]
                },
                {
                    "bSearchable": false,
                    "aTargets": [2]
                }
            ],
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#groupListDataTable_wrapper .col-md-6:eq(0)');

    });
</script>
</body>

</html>