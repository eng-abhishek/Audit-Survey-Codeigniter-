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
              <h3 class="card-title">Edit Surveys</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
               <?php echo form_open(base_url('survey/edit/'.service('request')->uri->getSegment(3)), ['class' => 'surveyform','id' => 'add_survey']); ?>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                          	<?php echo form_label(lang('Survey.survey_name'),'',['class' => 'field_required']); ?>
                            <?php
                                $survey_name = [
                                    'name'  => 'survey_name',
                                    'id'    => 'survey_name',
                                    'class'  => 'form-control',
                                    'value' => set_value('survey_name', $survey_data[0]['name'] ?: ''),
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

                        		echo form_dropdown('survey_template', $options, set_value('survey_template', $survey_data[0]['survey_id'] ?: ''), $survey_template);
                            ?>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo form_label(lang('Survey.assign_route'),'',['class' => 'field_required']); 
                            ?>
							<p class="selected_route"><?php echo $survey_data[0]['bus_route_name']; ?></p>
                            <?php
                            	$bus_route_data = explode(',',$survey_data[0]['bus_route']);
                            	$options = [];
                            	echo '<select id="assign_bus_route" name="assign_bus_route[]" class="form-control" multiple>';
                     			foreach($bus_route as $key => $value)
                     			{
                     				$selected = '';
                     				if(in_array($value['id'],$bus_route_data))
                     				{
                     					$selected = 'selected';
                     				}
                     				echo '<option value="'.$value['id'].'"'.set_select('assign_bus_route', $value['id']).$selected.'>'.$value['route_name'].'</option>';
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
                                    'value' => set_value('survey_description', $survey_data[0]['description'] ?: ''),
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

                          		$shifts_data = explode(',',$survey_data[0]['shifts']);
                            	$morning = '';
                 				if(in_array('morning',$shifts_data))
                 				{
                 					$morning = TRUE;
                 				}

                 				$noon = '';
                 				if(in_array('afternoon',$shifts_data))
                 				{
                 					$noon = TRUE;
                 				}


								$outside = '';
                 				if(in_array('outside',$shifts_data))
                 				{
                 					$outside = TRUE;
                 				}


                            	echo '<div class="row"><div class="col-sm-4">';
                            		echo '<label><input type="checkbox" name="shift[]" value="morning"'.set_checkbox("shift", "morning",$morning).'/> Morning</label>';
                            	echo '</div>';
								echo '<div class="col-sm-4">';
									echo '<label><input type="checkbox" name="shift[]" value="afternoon"'.set_checkbox("shift", "afternoon",$noon).'/> Afternoon</label>';
								echo '</div>';
								echo '<div class="col-sm-4">';
									echo '<label><input type="checkbox" name="shift[]" value="outside"'.set_checkbox("shift", "outside",$outside).'/> Outside</label>';
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

                        		echo form_dropdown('survey_type', $survey_types,  set_value('survey_template', $survey_data[0]['type'] ?: ''), $survey_type);
                            ?>
                          </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group shifts">
                            <?php echo form_label(lang('Survey.survey_no_shift'),'',['class' => 'field_required']); 

	                            $survey_no_shift = [
                                    'name'  => 'survey_no_shift',
                                    'id'    => 'survey_no_shift',
                                    'class'  => 'form-control',
                                    'value' => set_value('survey_no_shift', $survey_data[0]['no_shifts'] ?: ''),
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
                  	<?php if(!empty($ltc_list)) { ?>
                      <div class="col-sm-6">
                      	<table class="table table-light">
						  <thead>
						    <tr>
						      <th scope="col">Assigned LTC</th>
						      <th scope="col">Districts</th>
						     
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  		foreach($ltc_list as $key => $value)
						  		{
						  			echo "<tr>";
						  			echo "<td>".$value['code']."</td>";
						  			echo "<td>".$value['district_name']."</td>";
						  			echo "</tr>";
						  		}
						  	?>
						  
						  </tbody>
						</table>
                      </div>
                    <?php } ?>
                    <?php if(!empty($rtc_list)) { ?>
                      <div class="col-sm-6">
                      	<table class="table table-light">
						  <thead>
						    <tr>
						      <th scope="col">Assigned RTC</th>
						      <th scope="col">Districts</th>
						     
						    </tr>
						  </thead>
						  <tbody>
						  	<?php 
						  		foreach($rtc_list as $key => $value)
						  		{
						  			echo "<tr>";
						  			echo "<td>".$value['code']."</td>";
						  			echo "<td>".$value['district_name']."</td>";
						  			echo "</tr>";
						  		}
						  	?>
						  
						  </tbody>
						</table>
                      </div>
                    <?php } ?>
                  </div>

                  <div class="row">
                  		<div class="col-md-6">
	                    	<div class="button-switch float-left">
                                <?php 
                                    $checked = '';
                                    if($survey_data[0]['is_active'] == '1')
                                    {
                                        $checked = 'checked';
                                    }
                                ?>
		                        <input type="checkbox" name="active" value="1" id="switch-green" class="switch" <?php echo $checked; ?> />
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
  		$('input[name="survey_date_range"]').daterangepicker({startDate: "<?php echo date("m-d-Y", strtotime($survey_data[0]['start_date'])); ?>",endDate: "<?php echo  date("m-d-Y", strtotime($survey_data[0]['end_date'])); ?>" });

  		if($('#survey_type').val() == "<?php echo $survey_types['On-demand']; ?>")
  		{
  			$('.shifts').hide();
    		$("#survey_no_shift").rules("remove", "required");
  		}

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
