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
                            <a href="<?php echo base_url('school-districts/add'); ?>" class="btn btn-success float-right"><i class="fas fa-plus"></i> Add New</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="userListDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $record) { ?>
                                        <tr>
                                            <td><?php echo $record->name; ?></td>
                                            <td><?php echo $record->is_active == 1 ? '<i class="fas fa-check-square text-success"></i>' : '<i class="fas fa-window-close text-danger"></i>'; ?></td>
                                            <td>
                                                <a href="<?php echo base_url('school-districts/edit/' . base64_encode($record->id)); ?>"><i class="fas fa-edit"></i></a>
                                                <a href="<?php echo base_url('school-districts/delete/' . base64_encode($record->id)); ?>"><i class="fas fa-trash"></i></a>
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
    $(function() {
        $("#userListDataTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [1, 2]
                },
                {
                    "bSearchable": false,
                    "aTargets": [1, 2]
                }
            ]
        }).buttons().container().appendTo('#userListDataTable_wrapper .col-md-6:eq(0)');

    });
</script>
</body>

</html>