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
                    <h1>Survey</h1>
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
                                               <option value="0">Select Filter</option>
                                               <option value="name">Survey Name</option>
                                               <option value="template_name">Survey Template Name</option>
                                               <option value="assigned_username">Assigned User Name</option>
                                               <option value="assigned_usertype">Assigned Usertype</option>
                                               <option value="district_name">Districts</option>
                                               <option value="date">Date Range</option>
                                               <option value="created_by">Created by</option>
                                               <option value="is_active">Status</option>
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
                                <a href="<?php echo base_url('survey/add'); ?>" class="btn btn-warning float-right"><i class="fas fa-plus"></i> Add New</a>
                             </div>
                            </div></div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="surveyTemplateListDataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('Survey.table_id') ?></th>
                                        <th><?php echo lang('Survey.table_name') ?></th>
                                        <th><?php echo lang('Survey.table_template_name') ?></th>
                                        <th><?php echo lang('Survey.table_assigned') ?></th>
                                        <th><?php echo lang('Survey.table_assigned_type') ?></th>
                                        <th><?php echo lang('Survey.table_districts') ?></th>
                                        <th><?php echo lang('Survey.table_daterange') ?></th>
                                        <th><?php echo lang('Survey.table_created_by') ?></th>
                                        <th><?php echo lang('Survey.table_status') ?></th>
                                        <th><?php echo lang('Survey.table_action') ?></th>
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


<?php echo view('scripts'); ?>

<!-- Page specific script -->
<script>
    $(function() {
   
        
        table = $('#surveyTemplateListDataTable').DataTable({ 
            processing: true,
            serverSide: true,
            order: [], //init datatable not ordering
            ordering: false,
            "bInfo" : false,
            "bLengthChange": false,
            searching: false,
            ajax: {
                url: "<?php echo base_url('survey/ajaxDatatables')?>",
                data: function (d) {
                    d.search_value = $('#search_value').val();
                    d.listsearchfilter = $('#listsearchfilter').val();
                }
            },
            columns: [
                {data: 'no'},
                {data: 'name'},
                {data: 'survey_template_name'},
                {data: 'coordinator_names'},
                {data: 'coordinator_roles'},
                {data: 'coordinator_districts'},
                {data: 'date_range'},
                {data: 'created_by'},
                {data: 'status'},
                {data: 'action'}
            ],
           
        });

         $('#searchdt').click(function(event) {
            table.ajax.reload();
         });

        $('#listsearchfilter').change(function(){
            if($(this).val() == '0')
            {
                $('#search_value').val('');
                table.ajax.reload();
            }
        });

        $(document).on("click",".del_template",function() {
                var id = $(this).attr("data-id");
                var url="<?php echo base_url();?>";
                var r=confirm("Do you want to delete this?")
                if (r==true)
                  window.location = url+"/surveytemplate/delete/"+id;
                else
                  return false;
        });

    });

   
    
</script>
<?php echo view('footer'); ?>
