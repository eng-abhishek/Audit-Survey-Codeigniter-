<?php
echo view('header');
echo view('sidebar');
?>
<style>
.dataTables_length,#buscompany_table_list_filter { display: none; }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo lang('BusCompany.label_module_name'); ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                      <div class="container card-header">
                            <div class="row">
                            <div class="col-sm-8">
                
                                 <div class="row">
                                 <div class="col-lg-1 card-title">List</div> 
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="value" id="search_value" class="form-control" style="width:60%" placeholder="Enter Filter Value">
                                    </div>
                                       
                                </div>  
                                 <div class="col-lg-4">
                                     <div class="input-group">
                                        <select id="blistsearchfilter" class="form-control" style="width:40%">
                                           <option value="0">Select Filter</option>
                                           <option value="company_name">Company Name</option>
                                           <option value="address1">Address</option>
                                           <option value="phone">Contact</option>
                                           <option value="email">Email</option>
                                           <option value="is_active">Status</option>
                                        </select>
                                     </div>
                                </div>
                              
                                <div class="col-lg-2">
                                  <span class="input-group-btn">
                                          <button class="btn btn-secondary" id="buscompanysearchdt"><i class="glyphicon glyphicon-search"></i>Search</button>
                                  </span>
                                </div>
                              </div>
                             </div>

                            <div class="col-sm-4">
                               <a href="<?php echo base_url('bus-companies/add'); ?>" class="btn btn-warning float-right"><i class="fas fa-plus"></i> <?php echo form_label(lang('BusCompany.label_button_add')); ?></a>
                             </div>
                            </div></div>

                   

                        <div class="card-body">
                            <table id="buscompany_table_list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> <?php echo lang('BusCompany.table_label_no'); ?></th>
                                        <th> <?php echo lang('BusCompany.table_label_company_name'); ?></th>
                                        <th> <?php echo lang('BusCompany.table_label_address'); ?></th>
                                        <th> <?php echo lang('BusCompany.table_label_contact'); ?></th>
                                        <th> <?php echo lang('BusCompany.table_label_email'); ?></th>
                                        <th> <?php echo lang('BusCompany.table_label_routes'); ?></th>
                                        <th> <?php echo lang('BusCompany.table_label_status'); ?></th>
                                        <th> <?php echo lang('BusCompany.table_label_action'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
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
<script src="<?php echo base_url('assets/js/buscompany/buscompany.js'); ?>"></script>

<!-- Page specific script -->
<script>
    $(function() {
        table = $('#buscompany_table_list').DataTable({ 
            processing: true,
            serverSide: true,
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            order: [], //init datatable not ordering
            ordering: false,
            ajax: {
                url: "<?php echo base_url('bus-companies/ajaxDatatables') ?>",
                method: 'POST',
                data: function (d) {
                    d.search_value = $('#search_value').val();
                    d.listsearchfilter = $('#blistsearchfilter').val();
                }
            },
            columns: [
                {data: 'no'},
                {data: 'company_name'},
                {data: 'address1'},
                {data: 'phone'},
                {data: 'email'},
                {data: 'routes'},
                {data: 'is_active'},
                {data: 'action'}
            ],
           
        });

        $('#blistsearchfilter').change(function(){
			if($(this).val() == '0')
			{
			    $('#search_value').val('');
			    table.ajax.reload();
			}
   		});

         $('#buscompanysearchdt').click(function(event) {
            table.ajax.reload();
         });

    });
</script>

<?php echo view('footer'); ?>
