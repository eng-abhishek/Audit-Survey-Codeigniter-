<?php
echo view('header');
echo view('sidebar');
?>
<style>
  #fieldoptionlist,#fieldoptioncheckbox { display: none; }
  .error {color: red}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo lang('SurveyTemplate.page_heading') ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Survey Templates</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                  <!-- form start -->
                
                <?php echo form_open(base_url('surveytemplate/edit/'.$template_id), ['class' => 'surveytemplateform','id' => 'add_survey_form']); ?>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-6">
                        <label><?php echo lang('SurveyTemplate.template_name') ?></label>
                        <?php
                        $template_name = [
                                'type' => 'text',
                                'class' => 'form-control',
                                'name' => 'survey_template_name',
                                'id' => 'survey_template_name',
                                'value' => $template_name,
                                //'required' => TRUE
                            ];

                            echo form_input($template_name);
                        ?>
                    </div>
                      <!-- /.col -->
                      <div class="col-md-6">
                        <label><?php echo lang('SurveyTemplate.template_status') ?></label><br>
                        <?php
                            $dstatus = [
                                'name'    => 'template_status',
                                'id'      => 'template_status',
                                'class'  => 'form-control',
                                'type'    => 'checkbox',
                                'data-on-text' => 'Active',
                                'data-off-text' => 'Inactive',
                                'data-bootstrap-switch' => '',
                                'data-off-color' => 'danger',
                                'data-on-color' => 'success',
                                'value' => '1',
                            ];

                            if($status == 1)
                            {
                                $dstatus['checked'] = 'checked';
                            }

                            echo form_input($dstatus);
                        ?>
                        <input id='survey_template_status' type='hidden' value='<?php echo $status; ?>' name='template_status'>                        
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><?php echo lang('SurveyTemplate.add_field_button') ?></button>
                            </div>
                        </div>
                    </div>
                <!-- /.form-group -->
              </div>

               <table id="fieldsurveytable" class="table table-bordered table-striped">
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
                      <?php 
                        $i=1;
                        $hidden_fields='';
                        //echo "<pre>"; print_r($resultant); exit;
                        foreach($resultant as $value)
                        {
                            $ismandatory = 'No';
                            if($value['mandatory'] == '1')
                            {
                                $ismandatory = 'Yes';
                            }

                            echo "<tr data-rid=".$i."><td class='td_no_".$i."'>".$i."</td><td class='td_name_".$i."'>".$value['question_label']."</td><td class='td_type_".$i."'>".$value['question_type']."</td><td class='td_mandatory_".$i."'>".$ismandatory."</td><td><a class='editrow' data-rowid='".$i."' data-coln='field".$i." href='#'><i class='fas fa-edit'></i></a><a class='removerow' data-coln='field".$i."' href='#'><i class='fas fa-trash'></i></a></td></tr>";
                            
                            if($value['question_type'] == 'Text' || $value['question_type'] == 'Email' || $value['question_type'] == 'Number'  || $value['question_type'] == 'Datepicker'  || $value['question_type'] == 'Image'  || $value['question_type'] == 'Textarea')
                            {
                                $hidden_fields .= '<div class="field'.$i.'"><input type="hidden" class="field_'.$i.'_name" name="field['.$i.'][name]" value="'.$value['question_label'].'"><input type="hidden" class="field_'.$i.'_mandatory" name="field['.$i.'][mandatory]" value="'.$value['mandatory'].'"><input type="hidden" class="field_'.$i.'_type" name="field['.$i.'][type]" value="'.$value['question_type'].'"><input type="hidden" class="field_'.$i.'_question_id" name="field['.$i.'][question_id]" value="'.$value['question_id'].'"></div>';
                            }
                            else if($value['question_type'] == 'Checkbox')
                            {
                                $j=0;
                               
                                $hidden_fields .= '<div class="field'.$i.'"><input type="hidden" class="field_'.$i.'_name" name="field['.$i.'][name]" value="'.$value['question_label'].'"><input type="hidden" class="field_'.$i.'_mandatory" name="field['.$i.'][mandatory]" value="'.$value['mandatory'].'"><input type="hidden" class="field_'.$i.'_type" name="field['.$i.'][type]" value="'.$value['question_type'].'"><input type="hidden" class="field_'.$i.'_question_id" name="field['.$i.'][question_id]" value="'.$value['question_id'].'">';

                                foreach($value['option'] as $okey => $ovalue)
                                {
                                    $hidden_fields .= '<div class="option_row_'.$i.'"><input type="hidden" class="rc_option'.$i.'" id="rc_'.$i.'_option_'.$j.'" name="field['.$i.'][option]['.$j.'][label]" value="'.$ovalue['label'].'">';

                                    $hidden_fields .= '<input type="hidden"  id="rc_'.$i.'_option_'.$j.'_optionid" name="field['.$i.'][option]['.$j.'][option_id]" value="'.$okey.'"></div>';
                                    $j++;
                                }
                                $hidden_fields .='</div>';

                            }
                            else if($value['question_type'] == 'Dropdown')
                            {
                                $j=0;
                               
                                $hidden_fields .= '<div class="field'.$i.'"><input type="hidden" class="field_'.$i.'_name" name="field['.$i.'][name]" value="'.$value['question_label'].'"><input type="hidden" class="field_'.$i.'_mandatory" name="field['.$i.'][mandatory]" value="'.$value['mandatory'].'"><input type="hidden" class="field_'.$i.'_type" name="field['.$i.'][type]" value="'.$value['question_type'].'"><input type="hidden" class="field_'.$i.'_question_id" name="field['.$i.'][question_id]" value="'.$value['question_id'].'">';
                                foreach($value['option'] as $okey => $ovalue)
                                {
                                $hidden_fields .= '<div class="option_row_'.$i.'"><input type="hidden" id="field_'.$j.'_option_'.$j.'_0" name="field['.$i.'][option]['.$j.'][0]" value="'.$ovalue['label'].'"><input type="hidden" id="field_'.$j.'_option_'.$j.'_1" name="field['.$i.'][option]['.$j.'][1]" value="'.$ovalue['alert_notify'].'"><input type="hidden" id="field_'.$j.'_option_'.$j.'_2" name="field['.$i.'][option]['.$j.'][2]" value="'.$ovalue['end_notify'].'"><input type="hidden" id="field_'.$j.'_option_'.$j.'_3" name="field['.$i.'][option]['.$j.'][3]" value="'.$ovalue['alert_notes'].'"><input type="hidden" id="field_'.$j.'_option_'.$j.'_4" name="field['.$i.'][option]['.$j.'][4]" value="'.$ovalue['end_notes'].'"><input type="hidden" id="field_'.$j.'_option_'.$j.'_5" name="field['.$i.'][option]['.$j.'][5]" value="'.$okey.'"></div>';

                                    $j++;
                                }

                                $hidden_fields .= '</div>';
                            }
                            $i++;    
                        }
                        
                      ?>

                    </tbody>
                </table>
                <?php echo $hidden_fields; ?>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><?php echo lang('SurveyTemplate.update_field_button') ?></button>
                </div>
            <?php echo form_close(); ?>

              <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header" style="display:block;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?php echo lang('SurveyTemplate.add_field_button') ?></h4>
                          </div>
                          <div class="modal-body">
                            <form action="#" class='templatequestionForm' id='templatequestionForm'>
                                <input type="hidden" name="hidden_formtype" class="hidden_formtype" value="0" />
                                <input type="hidden" name="hidden_formrowid" class="hidden_formrowid" value="0" />

                                <input type="hidden" name="hidden_questionid" class="hidden_questionid" value="0" />
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6"></div>
                                </div>
                             
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                          <label><?php echo lang('SurveyTemplate.field_type') ?></label>
                                          <?php
                                            echo form_dropdown('shirts', $dropdown_types,'','id="texttype" class="form-control" required = TRUE');
                                          ?>
                                    </div>

                                </div>
                                

                            <div id="fieldoptionlist" class="card-body">
                              <button type="button" id="add_field_option" class="btn btn-info btn-lg"><?php echo lang('SurveyTemplate.add_option_label') ?></button>
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
                              <button type="submit" class="btn btn-primary savefield" ><?php echo lang('SurveyTemplate.save_field_button') ?></button>
                            </form>
                          </div>
                          <div class="modal-footer">
                          
                          </div>
                        </div>
                      </div>
                    </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
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
