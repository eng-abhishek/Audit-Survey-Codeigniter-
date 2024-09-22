<?php

namespace Modules\SurveyTemplate\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use IonAuth\Libraries\IonAuth;
use Modules\SurveyTemplate\Models\SurveyTemplateModel;
use Hermawan\DataTables\DataTable;
use Psr\Log\LoggerInterface;


class SurveyTemplate extends BaseController
{

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	       parent::initController($request, $response, $logger);
	       $this->isLoggedIn();
	     
		$this->configTemplate = config('SurveyTemplate');
		$this->surveytemplateModel = new SurveyTemplateModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Survey Templates',
			'records' => $this->surveytemplateModel->where('deleted', 0)->findAll()

		];
		return view('\Modules\SurveyTemplate\Views\list_survey', $data);
	}

	public function ajaxDatatables()
	{
		$builder = $this->surveytemplateModel->get_datatable($this->configAuditSurvey->table_survey_template);
        	return DataTable::of($builder)
        		->add('is_active', function($row){
        			$status = "Inactive";
        			if($row->is_active == '1')
        			{
        				$status = "Active";
        			}
        			
        			return $status;
    			})
    			->add('surveycount', function($row){
        			$surveycount = $this->surveytemplateModel->getwhere_record_count($this->configAuditSurvey->table_survey,array('survey_id'=> $row->id,'is_active' => '1','is_deleted' => '0'));
        			return $surveycount;
    			})
        		->add('action', function($row){
        			$action = '<a href="'.base_url('surveytemplate/edit/' . base64_encode($row->id)).'"><i class="fas fa-edit"></i></a>';

        			$action .='<a class="del_template" data-id="'.base64_encode($row->id).'"><i class="fas fa-trash"></i></a>';
        			return $action;
    			})
    			->filter(function ($builder, $request) {  
        			if ($request->listsearchfilter && $request->listsearchfilter == 'name')
            			$builder->where($request->listsearchfilter, $request->search_value);

            		if ($request->listsearchfilter && $request->listsearchfilter == 'is_active')
            		{
            			if(strtolower($request->search_value) == 'active')
            			{
            				$builder->where($request->listsearchfilter, '1');
            			}
            			else if(strtolower($request->search_value) == 'inactive')
            			{
            				$builder->where($request->listsearchfilter, '0');
            			}
            		}
    			})
               ->addNumbering('no') 
               ->toJson(true);
	}


	public function add()
	{
		$data = [
			'title' => 'Survey Template - Add',
			'dropdown_types' => $this->configTemplate->dropdown_types,
		];

		if ($this->request->getPost()) {
			//check validation here
			$this->validation->setRules([
    			'survey_template_name' => ['label' => lang('SurveyTemplate.error_security'), 'rules' => 'required|is_unique[survey_templates.name]'],
    			'field' => ['label' => lang('SurveyTemplate.error_security'), 'rules' => 'required'],
    			'field.*.name' => ['label' => lang('SurveyTemplate.error_field_name'), 'rules' => 'required'],
    			'field.*.type' => ['label' => lang('SurveyTemplate.error_field_type'), 'rules' => 'required'],
    			
			]);

			if($this->request->getPost('field'))
			{
				foreach($this->request->getPost('field') as $field)
				{
					if($field['type'] == "Radio" || $field['type'] == "Checkbox" || $field['type'] == "Dropdown")
					{
						$this->validation->setRules([
	    					'field.*.option' => ['label' => lang('SurveyTemplate.error_no_option'), 'rules' => 'required'],
	    			
						]);
					}
				}
			}

			//End of Validation part
			
			if ($this->validation->withRequest($this->request)->run()) {
			
				$insert_survey_templates = $this->surveytemplateModel->insert_data($this->configAuditSurvey->table_survey_template,array(
	            	"name" => $this->request->getPost('survey_template_name'),
	            	"is_active" => $this->request->getPost('template_status'),
	            	"created_by" => $this->ionAuth->user()->row()->id,
	              	"updated_by" => $this->ionAuth->user()->row()->id

	        	));


				//insert default questions
				$insert_system_generated_survey_question = $this->surveytemplateModel->insert_data($this->configAuditSurvey->table_survey_template_questions,array(
			            	"survey_template_id" => $insert_survey_templates,
	        		    	"question" => lang('SurveyTemplate.system_generated_question'),
		       		"question_type" => $data['dropdown_types']['Dropdown'],
		       		"is_required" => '1',
		       		"is_active" => '1',
		       		"is_system_generated" => '1',
	        			));

				foreach($this->configTemplate->default_question_options as $option)
				{
					$option_list_default_question[] = array(
						'template_question_id' => $insert_system_generated_survey_question,
						'template_id' => $insert_survey_templates,
						'value' => $option,
						'is_active' => '1'
					);
				}

				/* End of default question */

				$this->surveytemplateModel->insert_batch($this->configAuditSurvey->table_survey_template_options,$option_list_default_question);


				foreach($this->request->getPost('field') as $field)
				{
					$insert_survey_question = $this->surveytemplateModel->insert_data($this->configAuditSurvey->table_survey_template_questions,array(
			            	"survey_template_id" => $insert_survey_templates,
	        		    	"question" => $field['name'],
		       		    	"question_type" => $field['type'],
		       		    	"is_required" => $field['mandatory'],
		       		    	"is_active" => '1',
	        			));

					if($field['type'] == "Radio" || $field['type'] == "Checkbox")
					{
	        			$option_list = [];
	        			foreach($field['option'] as $option)
						{
							$option_list[] = array(
								'template_question_id' => $insert_survey_question,
								'template_id' => $insert_survey_templates,
								'value' => $option['label'],
								'is_active' => '1'
							);
						}

						$this->surveytemplateModel->insert_batch($this->configAuditSurvey->table_survey_template_options,$option_list);
					}
					else if($field['type'] == "Dropdown")
					{
						
	        			$option_list = [];
	        			foreach($field['option'] as $option)
						{
							$option_list[] = array(
								'template_question_id' => $insert_survey_question,
								'value' => $option[0],
								'is_alert_notify' => $option[1],
								'is_end_notify' => $option[2],
								'alert_notes' => $option[3],
								'end_audit_notes' => $option[4],
								'is_active' => '1'
							);
						}

						$this->surveytemplateModel->insert_batch($this->configAuditSurvey->table_survey_template_options,$option_list);

					}
				}

				$this->session->setFlashdata('success_message', 'Template created Successfully');
				return redirect()->to('/surveytemplate');
			}
			else 
			{
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}
		return view('\Modules\SurveyTemplate\Views\add_survey', $data);

	}

	public function edit($id)
	{
		$template_id = base64_decode($id);

		$data = $this->surveytemplateModel->getsurveytemplate($template_id);
		if(empty($data)){
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/surveytemplate');
		}

		$template_name = $template_status = '';
		$resultant = array();

		foreach($data as $key => $value)
		{
			$template_name = $value['template_name'];
			$template_status = $value['template_status'];

			/*$resultant[$value['template_id']]['name'] = $value['template_name'];
			$resultant[$value['template_id']]['status'] = $value['template_status'];*/
			$resultant[$value['question_id']]['question_label'] = $value['question_label'];
			$resultant[$value['question_id']]['question_type'] = $value['question_type'];
			$resultant[$value['question_id']]['mandatory'] = $value['mandatory'];
			$resultant[$value['question_id']]['question_id'] = $value['question_id'];

			if($value['question_type'] == 'Dropdown')
			{
				if($value['optionactive'] == 1)
				{
					$resultant[$value['question_id']]['option'][$value['option_id']]['label'] = $value['option_value'];
					$resultant[$value['question_id']]['option'][$value['option_id']]['alert_notify'] = $value['alert_notify'];
					$resultant[$value['question_id']]['option'][$value['option_id']]['end_notify'] = $value['end_notify'];
					$resultant[$value['question_id']]['option'][$value['option_id']]['alert_notes'] = $value['alert_notes'];
					$resultant[$value['question_id']]['option'][$value['option_id']]['end_notes'] = $value['end_notes'];
				}
			}
			if($value['question_type'] == 'Checkbox')
			{
				if($value['optionactive'] == 1)
				{
					$resultant[$value['question_id']]['option'][$value['option_id']]['label'] = $value['option_value'];
					
				}
			}

			//$resultant[$value['template_id']][$value['question_id']][] = $value;
		}

		if ($this->request->getPost()) {
			if($template_name == $this->request->getPost('survey_template_name'))
			{
				$this->validation->setRules([
				'survey_template_name' => ['label' => lang('SurveyTemplate.error_security'), 'rules' => 'required'],
	    			'field.*.name' => ['label' => lang('SurveyTemplate.error_field_name'), 'rules' => 'required'],
	    			'field.*.type' => ['label' => lang('SurveyTemplate.error_field_type'), 'rules' => 'required'],
	    			
				]);
			}
			else
			{
				$this->validation->setRules([
					'survey_template_name' => ['label' => lang('SurveyTemplate.error_security'), 'rules' => 'required|is_unique[survey_templates.name]'],
		    			'field.*.name' => ['label' => lang('SurveyTemplate.error_field_name'), 'rules' => 'required'],
		    			'field.*.type' => ['label' => lang('SurveyTemplate.error_field_type'), 'rules' => 'required'],
		    			
					]);

			}

			/*if($this->request->getPost('field'))
			{
				foreach($this->request->getPost('field') as $field)
				{
					if($field['type'] == "Radio" || $field['type'] == "Checkbox" || $field['type'] == "Dropdown")
					{
						$this->validation->setRules([
	    					'field.*.option' => ['label' => lang('SurveyTemplate.error_no_option'), 'rules' => 'required'],
	    			
						]);
					}
				}
			}*/

			if ($this->validation->withRequest($this->request)->run()) {
			//update the template question and question option to inactive

			$update_survey_templates = $this->surveytemplateModel->update_data($template_id,$this->configAuditSurvey->table_survey_template,array(
	            	"name" => $this->request->getPost('survey_template_name'),
	            	"is_active" => $this->request->getPost('template_status'),
	              	"updated_by" => $this->ionAuth->user()->row()->id
	        	));

			$update_survey_questions = $this->surveytemplateModel->update_where($this->configAuditSurvey->table_survey_template_questions,array(
	            	"is_active" => 0
	        	),array('survey_template_id' => $template_id));
			$update_survey_answers = $this->surveytemplateModel->update_where($this->configAuditSurvey->table_survey_template_options,array(
	            	"is_active" => 0
	        	),array('template_id' => $template_id));

			if($this->request->getPost('field'))
			{
				foreach($this->request->getPost('field') as $field)
				{
					if($field['question_id'] != 0)
					{
						$insert_survey_question = $this->surveytemplateModel->update_data($field['question_id'],$this->configAuditSurvey->table_survey_template_questions,array(
		        		    	"question" => $field['name'],
			       		    	"question_type" => $field['type'],
			       		    	"is_required" => $field['mandatory'],
			       		    	"is_active" => '1',
		        			));

						if($field['type'] == "Radio" || $field['type'] == "Checkbox")
						{
		        			$option_list = [];
		        			foreach($field['option'] as $option)
							{
								$option_list = array(
										'value' => $option['label'],
										'is_active' => '1'
									);
								if($option['option_id'] != 0)
								{
						
									$this->surveytemplateModel->update_data($option['option_id'],$this->configAuditSurvey->table_survey_template_options,$option_list);
								}
								else
								{
									//insert code here
									$option_list['template_question_id'] = $field['question_id'];
									$option_list['template_id'] = $template_id;
									$insert_survey_templates = $this->surveytemplateModel->insert_data($this->configAuditSurvey->table_survey_template_options,$option_list);
								}
							}
							
						}
						else if($field['type'] == "Dropdown")
						{
		        			$option_list = [];
		        			foreach($field['option'] as $option)
							{

								$option_list = array(
									'value' => $option[0],
									'is_alert_notify' => $option[1],
									'is_end_notify' => $option[2],
									'alert_notes' => $option[3],
									'end_audit_notes' => $option[4],
									'is_active' => '1'
								);

								if($option[5] != 0)
								{
									$update_survey_option = $this->surveytemplateModel->update_data($option[5],$this->configAuditSurvey->table_survey_template_options,$option_list);
								}
								else
								{
									//insert code here
									$option_list['template_question_id'] = $field['question_id'];
									$option_list['template_id'] = $template_id;


									$insert_survey_templates = $this->surveytemplateModel->insert_data($this->configAuditSurvey->table_survey_template_options,$option_list);
										
								}
							}
						}
					}
					else
					{
						$insert_survey_question = $this->surveytemplateModel->insert_data($this->configAuditSurvey->table_survey_template_questions,array(
			            	"survey_template_id" => $template_id,
	        		    	"question" => $field['name'],
		       		    	"question_type" => $field['type'],
		       		    	"is_required" => $field['mandatory'],
		       		    	"is_active" => '1',
	        			));

						if($field['type'] == "Radio" || $field['type'] == "Checkbox")
						{
		        			$option_list = [];
		        			foreach($field['option'] as $option)
							{
								$option_list[] = array(
									'template_question_id' => $insert_survey_question,
									'template_id' => $template_id,
									'value' => $option,
									'is_active' => '1'
								);
							}

							$this->surveytemplateModel->insert_batch($this->configAuditSurvey->table_survey_template_options,$option_list);
						}
						else if($field['type'] == "Dropdown")
						{
							
		        			$option_list = [];
		        			foreach($field['option'] as $option)
							{
								$option_list[] = array(
									'template_question_id' => $insert_survey_question,
									'template_id' => $template_id,
									'value' => $option[0],
									'is_alert_notify' => $option[1],
									'is_end_notify' => $option[2],
									'alert_notes' => $option[3],
									'end_audit_notes' => $option[4],
									'is_active' => '1'
								);
							}

							$this->surveytemplateModel->insert_batch($this->configAuditSurvey->table_survey_template_options,$option_list);

						}
					}
				}
			}
			$this->session->setFlashdata('success_message', 'Template updated Successfully');
			return redirect()->to('/surveytemplate');
		}
		else 
		{
			$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
		}
		}

		// end of post
		
		$data = [
			'resultant' => $resultant,
			'template_name' => $template_name,
			'status' => $template_status,
			'template_id' => base64_encode($template_id),
			'dropdown_types' => $this->configTemplate->dropdown_types,
		];

		return view('\Modules\SurveyTemplate\Views\edit_survey', $data);
	}


	public function delete($id)
	{
		$template_id = base64_decode($id);
		$record = $this->surveytemplateModel->select('*')->find($template_id);
		if ($record) 
		{
			$data = [
	    			'deleted' => '1',
			];
			$this->surveytemplateModel->update($template_id, $data);

			return redirect()->back()->with('success_message', 'Deleted Successfully');
		}
		else
		{
			return redirect()->back()->with('error_message', 'Invalid record id');
		}
	}

	public function checktemplatename()
	{
		$templatename = $this->request->getPost('survey_template_name');
    		$exists = $this->surveytemplateModel->filename_exists($templatename,$this->configAuditSurvey->table_survey_template);
  	    	$count = count($exists);

	       if (empty($count)) {
		     $return = true;
		} else {
		    $return = false;
		}

		echo json_encode($return);

	}
}
