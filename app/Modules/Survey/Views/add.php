<?php
echo view('header');
echo view('sidebar');
?>
<style>
  #fieldoptionlist,#fieldoptioncheckbox { display: none; }
  .error {color: red}
  .modal-custom { max-width: 1000px; }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo lang('Survey.page_heading') ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card form-box">
            <div class="card-header">
              <h3 class="card-title">Add Surveys</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <?php echo form_open(base_url('survey/add'), ['class' => 'surveyform','id' => 'add_survey']); ?>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                          	<?php echo form_label(lang('Survey.survey_name'),'',['class' => 'field_required']); ?>
                            <?php
                                $survey_name = [
                                    'name'  => 'survey_name',
                                    'id'    => 'survey_name',
                                    'class'  => 'form-control',
                                    'value' => set_value('survey_name'),
                                    'required' => TRUE,
                                    'maxlength' => '150',
                                ];
                                echo form_input($survey_name);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                          <?php echo form_label(lang('Survey.survey_template_name'),'',['class' => 'field_required']); ?>
                           <?php
                            	$options = ['' => '--Select--'];
                     			foreach($survey_template as $key => $value)
                     			{
                     				$options[$value['id']] = $value['name'];
                     			}

                        		$survey_template = ["id" => "survey_template", "class" => "form-control"];

                        		echo form_dropdown('survey_template', $options, set_value('survey_template'), $survey_template);
                            ?>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo form_label(lang('Survey.assign_route'),'',['class' => 'field_required']); 
                            	$options = [];
                            	echo '<select id="assign_bus_route" name="assign_bus_route[]" class="form-control" multiple>';
                     			foreach($bus_route as $key => $value)
                     			{
                     				echo '<option value="'.$value['id'].'"'.set_select('assign_bus_route', $value['id']).'>'.$value['route_name'].'</option>';
                     			}

                     			echo '</select>';
                            ?>
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo form_label(lang('Survey.survey_description'),''); 
                                $survey_description = [
	                                'name'  => 'survey_description',
	                                'id'    => 'survey_description',
	                                'class'  => 'form-control',
	                                'rows' => 2,
	                                'value' => set_value('survey_description'),
                            	];
                            	echo form_textarea($survey_description);
                            ?>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                          	<?php echo form_label(lang('Survey.survey_shift'),'',['class' => 'field_required']); 
                            	echo '<div class="row"><div class="col-sm-4">';
                            		echo '<label><input type="checkbox" name="shift[]" value="morning"'.set_checkbox("shift", "morning").'/> Morning</label>';
                            	echo '</div>';
								echo '<div class="col-sm-4">';
									echo '<label><input type="checkbox" name="shift[]" value="afternoon"'.set_checkbox("shift", "afternoon").'/> Afternoon</label>';
								echo '</div>';
								echo '<div class="col-sm-4">';
									echo '<label><input type="checkbox" name="shift[]" value="outside"'.set_checkbox("shift", "outside").'/> Outside</label>';
								echo '</div></div>';
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                             <?php echo form_label(lang('Survey.survey_date_range'),'',['class' => 'field_required']); 
	                              $survey_date_range = [
	                                'name'  => 'survey_date_range',
	                                'id'    => 'survey_date_range',
	                                'class'  => 'form-control',
	                                'value' => set_value('survey_date_range'),
	                                'type' => 'text',
	                                'required' => TRUE,
	                            ];
	                            echo form_input($survey_date_range);
                            ?>
                          </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo form_label(lang('Survey.survey_type'),'',['class' => 'field_required']); 
		                                     	
                        		$survey_type = ["id" => "survey_type", "class" => "form-control"];

                        		echo form_dropdown('survey_type', $survey_types, '', $survey_type);
                            ?>
                          </div>
                      </div>
                      <div class="col-sm-6 shifts">
                        <div class="form-group">
                            <?php echo form_label(lang('Survey.survey_no_shift'),'',['class' => 'field_required']); 

	                            $survey_no_shift = [
	                                'name'  => 'survey_no_shift',
	                                'id'    => 'survey_no_shift',
	                                'class'  => 'form-control',
	                                'value' => set_value('survey_no_shift'),
	                                'type' => 'number',
	                                'required' => TRUE,
	                                'max' => '3',
                                    'min' => '1'
	                            ];
                            	echo form_input($survey_no_shift);
                            ?>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                  		<div class="col-md-6">
	                    	<div class="button-switch float-left">
		                        <input type="checkbox" name="active" value="1" id="switch-green" class="switch" checked />
		                        <label for="switch-blue" class="lbl-off">inactive</label>
		                        <label for="switch-blue" class="lbl-on">active</label>
	                     	</div>
	                  	</div>
	                  	<div class="col-md-6">
	                  		<p>&nbsp;</p>
	                  	</div>
                  </div>
                  <div class="card-footer">
                        <?php echo form_submit('submit', lang('BusCompany.label_button_create'), ['class' => 'btn btn-warning float-right ']); ?>
                  </div>
              <?php echo form_close(); ?>
            </div>
            <!-- /.card-body -->
          </div>
      </div><!-- /.container-fluid -->
    </section>

</div>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->



<?php echo view('scripts'); ?>
<script src="<?php echo base_url('assets/js/survey/survey.js'); ?>"></script>

<script>
	$(function() {
		$('.shifts').hide();
  		$('input[name="survey_date_range"]').daterangepicker();

  		$('#survey_type').change(function(){
    			if($(this).val() == "<?php echo $survey_types['On-demand']; ?>")
    			{
    				$('.shifts').hide();
    				$("#survey_no_shift").rules("remove", "required");
    			}
    			else
    			{
    				$('.shifts').show();
    				$("#survey_no_shift").rules("add", "required");
    			}
  		});

	});
</script>

<?php echo view('footer'); ?>
