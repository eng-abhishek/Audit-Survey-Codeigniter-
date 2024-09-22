<?php
echo view('header');
echo view('sidebar');
?>
<style>
  #fieldoptionlist,#fieldoptioncheckbox,#add_field_option { display: none; }
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
                    <h1><?php echo lang('SurveyTemplate.new_survey_template') ?></h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

     <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card form-box">
            <!-- <div class="card-header">
              <h3 class="card-title">Add Surveys</h3>
            </div> -->
            <!-- /.card-header -->
            <div class="card-body">
               <?php echo form_open(base_url('surveytemplate/add'), ['class' => 'surveytemplateform','id' => 'add_survey_form']); ?>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo form_label(lang('SurveyTemplate.template_name'),'',['class' => 'field_required']); ?>
                            <?php
                                $template_name = [
                                    'type' => 'text',
                                    'class' => 'form-control col-sm-10',
                                    'name' => 'survey_template_name',
                                    'id' => 'survey_template_name',
                                    'value' => set_value('survey_template_name'),
                                    'required' => TRUE
                                ];

                                echo form_input($template_name);
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                          <?php //echo form_label(lang('SurveyTemplate.template_status')); ?>
                           <?php
                                $status = [
                                    'name'    => 'template_status',
                                    'id'      => 'template_status',
                                    'class'  => 'form-control',
                                    'type'    => 'checkbox',
                                    'data-on-text' => 'Active',
                                    'data-off-text' => 'Inactive',
                                    'data-bootstrap-switch' => '',
                                    'data-off-color' => 'danger',
                                    'data-on-color' => 'success',
                                    'value' => '0'
                                ];
                                //echo form_input($status);
                            ?>
                            <div class="button-switch float-left">
                                <input type="checkbox" name="template_status" value="1" id="template_status" class="switch" checked />
                                <label for="switch-blue" class="lbl-off">inactive</label>
                                <label for="switch-blue" class="lbl-on">active</label>
                            </div>
                           <!--  <input id='survey_template_status' type='hidden' value='0' name='template_status'> -->
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="form-group">
                                <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#myModal"><i class="fas fa-plus"></i><?php echo lang('SurveyTemplate.add_field_button') ?></button>
                              </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                           
                           <table id="fieldsurveytable" class="table table-bordered table-striped" style="display:none;">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('SurveyTemplate.table_template_no') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_template_name') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_template_type') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_template_mandatory') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_template_action') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="field_tbody">
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
                  <div class="card-footer">
                        <button type="submit" class="btn btn-warning float-right"><?php echo lang('SurveyTemplate.save_field_button') ?></button>
                  </div>
              <?php echo form_close(); ?>

              <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog modal-custom">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header" style="display:block;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Field</h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" class='templatequestionForm' id='templatequestionForm'>
                                <input type="hidden" name="hidden_formtype" class="hidden_formtype" value="0" />
                                <input type="hidden" name="hidden_formrowid" class="hidden_formrowid" value="0" />

                                <input type="hidden" name="hidden_questionid" class="hidden_questionid" value="0" />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label><?php echo lang('SurveyTemplate.field_name') ?></label>
                                            <?php
                                            $question_name = [
                                                'value'     => '',
                                                'name' => 'field_inputname',
                                                'type' => 'text',
                                                'class'      => 'form-control field_inputname',
                                            ];

                                            echo form_input($question_name);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                             
                                <div class="row">
                                    <div class="col-md-12">
                                      <label><?php echo lang('SurveyTemplate.field_mandatory') ?></label>
                                      <?php
                                            $is_mandatory = [
                                                'value'     => '',
                                                'name' => 'field_ismandatory',
                                                'type' => 'checkbox',
                                                'class'      => 'field_ismandatory',
                                            ];

                                            echo form_input($is_mandatory);
                                        ?>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                              <label><?php echo lang('SurveyTemplate.field_type') ?></label>
                                              <?php
                                                echo form_dropdown('shirts', $dropdown_types,'','id="texttype" class="form-control" required = TRUE');
                                              ?>
                                        </div>
                                </div>
                             

                            <div id="fieldoptionlist" class="card-body">
                              
                            <table id="dynamicoption" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('SurveyTemplate.table_field_options') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_field_alertflag') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_field_endflag') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_field_alert_notes') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_field_end_audit_notes') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_field_actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                  
                                </tbody>
                            </table>
                        </div>

                        <div id="fieldoptioncheckbox" class="card-body">
                            <button type="button" id="add_field_checkbox" class="btn btn-info btn-lg"><?php echo lang('SurveyTemplate.add_option_button') ?></button>
                            <table id="dynamiccheckbox" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('SurveyTemplate.table_field_options') ?></th>
                                        <th><?php echo lang('SurveyTemplate.table_field_actions') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_checkbox">
                                  
                                </tbody>
                            </table>
                        </div>
                        <div class="add_field_button">
                             <button type="submit" class="savefield btn btn-warning float-right" ><?php echo lang('SurveyTemplate.save_field_button') ?></button>

                            <button type="button" id="add_field_option" class="btn btn-warning float-right"><i class="fas fa-plus"></i><?php echo lang('SurveyTemplate.add_option_label') ?></button>
                        </div>
                        </form>
                        </div>
                      <div class="modal-footer">
                      
                      </div>
                        </div>
                      </div>
                    </div>

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

<script src="<?php echo base_url('assets/js/surveytemplate/surveytemplate.js'); ?>"></script>

<?php echo view('footer'); ?>
