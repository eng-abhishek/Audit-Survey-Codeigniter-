<?php

namespace Modules\Survey\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use IonAuth\Libraries\IonAuth;
use Modules\Survey\Models\SurveyModel;
use Hermawan\DataTables\DataTable;
use Psr\Log\LoggerInterface;
use Modules\Survey\Models\CustomModel;
use Modules\Survey\Models\SurveyShiftModel;
use Modules\Survey\Models\SurveyBusRouteModel;


class Survey extends BaseController
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	    parent::initController($request, $response, $logger);
	       $this->isLoggedIn();
	     
		$this->surveyModel = new SurveyModel();
		$this->surveyShiftModel = new SurveyShiftModel();
		$this->customModel = new CustomModel();
		$this->surveyRouteModel = new SurveyBusRouteModel();
		$this->configSurvey = config('Survey');

	}

	public function index()
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}
		
		$data = [
			'title' => 'Survey',
		];
		return view('\Modules\Survey\Views\list', $data);
	}


	public function ajaxDatatables()
	{
		$builder = $this->customModel->get_datatable($this->configAuditSurvey->table_survey);
        return DataTable::of($builder)
        		->add('status', function($row){
        			$status = "Inactive";
        			if($row->is_active == '1')
        			{
        				$status = "Active";
        			}
        			
        			return $status;
    			})
    			->add('coordinator_names', function($row){
        			$coordinator = explode(',',$row->coordinator_names);
        			$count = count($coordinator);

        			if($count > 1)
        			{
        				return $coordinator[0]." + ".($count - 1);
        			}
        			else
        			{
        				return $coordinator[0];
        			}
    			})
    			->add('coordinator_roles', function($row){
        			$coordinator_role = explode(',',$row->coordinator_roles);
        			$count = count($coordinator_role);

        			if($count > 1)
        			{
        				return $coordinator_role[0]." + ".($count - 1);
        			}
        			else
        			{
        				return $coordinator_role[0];
        			}
    			})
    			->add('coordinator_districts', function($row){
        			$coordinator_district = explode(',',$row->coordinator_districts);
        			$count = count($coordinator_district);

        			if($count > 1)
        			{
        				return $coordinator_district[0]." + ".($count - 1);
        			}
        			else
        			{
        				return $coordinator_district[0];
        			}
    			})
    			->add('date_range', function($row){
        			return date("m/d/Y", strtotime($row->start_date)). "-".date("m/d/Y", strtotime($row->end_date));
    			})
        		->add('action', function($row){
        			$action = '<a href="'.base_url('survey/edit/' . base64_encode($row->id)).'">Edit</a>/';

        			$action .='<a href="'.base_url('survey/view/' . base64_encode($row->id)).'">View</a>/';
        			$action .= '<a href="#">View Response</a>/';
        			$action .= '<a href="#">Download</a>';
        			return $action;
    			})
    			->filter(function ($builder, $request) {  
        			if ($request->listsearchfilter && $request->listsearchfilter == 'name')
            			$builder->where('a.'.$request->listsearchfilter, $request->search_value);

        			if ($request->listsearchfilter && $request->listsearchfilter == 'district_name')
        				$builder->where("i.district_name LIKE '%".$request->search_value."%'", NULL, FALSE);

        			if ($request->listsearchfilter && $request->listsearchfilter == 'assigned_username')
        				$builder->where("CONCAT(f.first_name, ' ', f.last_name) LIKE '%".$request->search_value."%'", NULL, FALSE);

        			if ($request->listsearchfilter && $request->listsearchfilter == 'template_name')
        				$builder->where("b.name LIKE '%".$request->search_value."%'", NULL, FALSE);

        			if ($request->listsearchfilter && $request->listsearchfilter == 'assigned_usertype')
        				$builder->where("g.code LIKE '%".$request->search_value."%'", NULL, FALSE);

					if ($request->listsearchfilter && $request->listsearchfilter == 'created_by')
        				$builder->where("CONCAT(c.first_name, ' ', c.last_name) LIKE '%".$request->search_value."%'", NULL, FALSE);

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
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}

		$data = [
			'title' => 'Survey - Add',
			'bus_route' => $this->customModel->getwhere_record($this->configAuditSurvey->table_bus_company,array('is_active' => '1','is_deleted' => '0')),
			'survey_template' => $this->customModel->getwhere_record($this->configAuditSurvey->table_survey_template,array('is_active' => '1','deleted' => '0')),
			'survey_types' => $this->configAuditSurvey->survey_types,
		];

		if ($this->request->getPost()) {
			$this->validation->setRule('assign_bus_route', 'Assign Bus Routes', 'required');
			$this->validation->setRule('shift', 'Shift', 'required');
			$this->validation->setRule('survey_name', 'Survey Name', 'required|is_unique[surveys.name]');
			$this->validation->setRule('survey_template', 'Survey Template', 'required');
			$this->validation->setRule('survey_date_range', 'Date Range', 'required');
			$this->validation->setRule('survey_type', 'Survey Type', 'required');

			if(trim($this->request->getPost('survey_type')) == $data['survey_types']['System Trigger'])
			{
				$this->validation->setRule('survey_no_shift', 'No of Surveys per shift', 'required');
			}

			if ($this->validation->withRequest($this->request)->run()) {
				$date_start_end = explode('-',$this->request->getPost('survey_date_range'));
				$insertData = [
					'survey_id' => trim($this->request->getPost('survey_template')),
					'name' 	=> trim($this->request->getPost('survey_name')),
					'description' 	=> trim($this->request->getPost('survey_description')),
					'start_date' 	=> trim(date('Y-m-d',strtotime($date_start_end[0]))),
					'end_date' => trim(date('Y-m-d',strtotime($date_start_end[1]))),
					'no_shifts' 	=> trim($this->request->getPost('survey_no_shift')),
					'type'=> trim($this->request->getPost('survey_type')),
					'created_by'=> $this->ionAuth->user()->row()->id
				];

				if($this->request->getPost('active'))
				{
					$insertData['is_active'] = $this->request->getPost('active');
				}
				else
				{
					$insertData['is_active'] = '0';
				}

				if ($insertSurvey = $this->surveyModel->insert($insertData)) {

					$insert_oac = array();
					//insert into shift table and bus route table
					if($this->request->getPost('assign_bus_route'))
					{
						foreach($this->request->getPost('assign_bus_route') as $option)
						{
							$assign_bus_route[] = array(
								'surveys_id' => $insertSurvey,
								'bus_route_id' => $option,
								'created_at' => date('Y-m-d H:i:s'),
								'updated_at' => date('Y-m-d H:i:s'),
								'is_deleted' => '0'
							);


							//insert into survey schedule
							if(trim($this->request->getPost('survey_type')) == $data['survey_types']['On-demand'])
							{
								//get all active oac and assign to them
								$get_oac = $this->customModel->getuserByRoute($option);
								if(!empty($get_oac))
								{
									foreach($get_oac as $key => $value)
									{
										$insert_oac[] = array(
											'survey_id' => $insertSurvey,
											'user_id' => $value['id'],
											'school_destination_id' => $value['school_destination_id'],
											'status' => ACTIVE_STATUS,
											'created_by' => $this->ionAuth->user()->row()->id,
											'created_on' => date('Y-m-d H:i:s'),
										);
									}
									
								}
							}
							else
							{
								//random pick

							}
						}

						$this->customModel->insert_batch($this->configAuditSurvey->table_busroute_survey,$assign_bus_route);

						$this->customModel->insert_batch($this->configAuditSurvey->table_survey_schedule,array_unique($insert_oac, SORT_REGULAR));
					}


					if($this->request->getPost('shift'))
					{
						foreach($this->request->getPost('shift') as $option)
						{
							$survey_shift[] = array(
								'survey_id' => $insertSurvey,
								'survey_shifts' => $option,
								'created_at' => date('Y-m-d H:i:s'),
								'status' => '1',
							);
						}
						$this->customModel->insert_batch($this->configAuditSurvey->table_survey_shift,$survey_shift);
					}

					$this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/survey/add');
				} else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
			}
			else {
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}		
		}

		return view('\Modules\Survey\Views\add', $data);
	}



	public function edit($id)
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}

		$id = base64_decode($id);
		$rtc_array = [];
		$ltc_array = [];

		$data = [
			'title' => 'Survey - Edit',
			'bus_route' => $this->customModel->getwhere_record($this->configAuditSurvey->table_bus_company,array('is_active' => '1','is_deleted' => '0')),
			'survey_template' => $this->customModel->getwhere_record($this->configAuditSurvey->table_survey_template,array('is_active' => '1','deleted' => '0')),
			'survey_types' => $this->configAuditSurvey->survey_types,
			'survey_data' => $this->customModel->get_survey($id),
			'survey_shift' => $this->customModel->getwhere_record($this->configAuditSurvey->table_survey_shift,array('survey_id' => $id)),
			'survey_bus_route' => $this->customModel->getwhere_record($this->configAuditSurvey->table_busroute_survey,array('surveys_id' => $id)),
		];

			//explode bus route
		$routes = explode(',',$data['survey_data'][0]['bus_route']);

		foreach($routes as $key => $value)
		{
			$get_user_route = $this->customModel->get_coordinators($value);
			if($get_user_route[0]['code'] == ROLE_LTC)
			{
				$ltc_array[] = $get_user_route[0];
			}

			if($get_user_route[0]['code'] == ROLE_RTC)
			{
				$rtc_array[] = $get_user_route[0];
			}
		}

		$data['rtc_list'] = $rtc_array;
		$data['ltc_list'] = $ltc_array;

		if ($this->request->getPost()) {
			if($data['survey_data'][0]['name'] != $this->request->getPost('survey_name'))
			{
				$this->validation->setRule('survey_name', 'Survey Name', 'required|is_unique[surveys.name]');
			}
			$this->validation->setRule('assign_bus_route', 'Assign Bus Routes', 'required');
			$this->validation->setRule('shift', 'Shift', 'required');
			$this->validation->setRule('survey_template', 'Survey Template', 'required');
			$this->validation->setRule('survey_date_range', 'Date Range', 'required');
			$this->validation->setRule('survey_type', 'Survey Type', 'required');
			if(trim($this->request->getPost('survey_type')) == $data['survey_types']['System Trigger'])
			{
				$this->validation->setRule('survey_no_shift', 'No of Surveys per shift', 'required');
			}
			if ($this->validation->withRequest($this->request)->run()) {
				$insert_oac = array();
				$date_start_end = explode('-',$this->request->getPost('survey_date_range'));

				$updateData = [
					'survey_id' => trim($this->request->getPost('survey_template')),
					'name' 	=> trim($this->request->getPost('survey_name')),
					'description' 	=> trim($this->request->getPost('survey_description')),
					'start_date' 	=> trim(date('Y-m-d',strtotime($date_start_end[0]))),
					'end_date' => trim(date('Y-m-d',strtotime($date_start_end[1]))),
					'no_shifts' 	=> trim($this->request->getPost('survey_no_shift')),
					'created_by'=> $this->ionAuth->user()->row()->id
				];

				if($this->request->getPost('active'))
				{
					$updateData['is_active'] = $this->request->getPost('active');
				}
				else
				{
					$updateData['is_active'] = '0';
				}

				if ($this->surveyModel->update($id,$updateData)) {
					$this->customModel->update_global(array('survey_id' => $id),$this->configAuditSurvey->table_survey_shift,array('status' => 0));

					$this->customModel->update_global(array('surveys_id' => $id),$this->configAuditSurvey->table_busroute_survey,array('is_deleted' => 1));

					//update survey_schedule
					$this->customModel->update_global(array('survey_id' => $id),$this->configAuditSurvey->table_survey_schedule,array('status' => 0));

					//check and update the value

					$update_id = array();
					foreach($this->request->getPost('shift') as $key => $value)
					{
						$search = array_search($value, array_column($data['survey_shift'], 'survey_shifts'));

						if($search !== false) 
						{
							$update_id[] = $data['survey_shift'][$search]['id'];
						}
						else
						{
							//insert
							$insert_shift = array(
												'survey_id' => $id,
												'survey_shifts' => trim($value),
												'status' => ACTIVE_STATUS,
												'created_at' => date('Y-m-d H:i:s')
											);
							$this->surveyShiftModel->insert($insert_shift);
						}

					}
					if(!empty($update_id))
					{
						$data_shift = [
						    'status' => 1,
						];

						$this->surveyShiftModel->update($update_id,$data_shift);
					}


					//insert in bus route
					$update_busroute = array();
					foreach($this->request->getPost('assign_bus_route') as $key => $value)
					{
						$search_bus_route = array_search($value,  array_column($data['survey_bus_route'], 'bus_route_id'));

						if($search_bus_route !== false) 
						{
							$update_busroute[] = $data['survey_bus_route'][$search_bus_route]['id'];
						}
						else
						{
							//insert
							$insert_route = array(
												'surveys_id' => $id,
												'bus_route_id' => trim($value),
												'is_deleted' => NOT_ACTIVE_STATUS,
												'created_at' => date('Y-m-d H:i:s'),
												'updated_at' => date('Y-m-d H:i:s'),
											);
							$this->surveyRouteModel->insert($insert_route);
						}


						//insert into survey schedule
						if(trim($this->request->getPost('survey_type')) == $data['survey_types']['On-demand'])
						{
							//get all active oac and assign to them
							$get_oac = $this->customModel->getuserByRoute(trim($value));
							if(!empty($get_oac))
							{
								foreach($get_oac as $key => $value)
								{
									$insert_oac[] = array(
										'survey_id' => $id,
										'user_id' => $value['id'],
										'school_destination_id' => $value['school_destination_id'],
										'status' => ACTIVE_STATUS,
										'created_by' => $this->ionAuth->user()->row()->id,
										'created_on' => date('Y-m-d H:i:s'),
									);
								}
								
							}
						}
						else
						{
							//random pick
							
						}
					}

					if(!empty($update_busroute))
					{
						$bus_route_data = [
						    'is_deleted' => 0,
						];

						$this->surveyRouteModel->update($update_busroute,$bus_route_data);
					}

					if(!empty($insert_oac))
					{
						$this->customModel->insert_batch($this->configAuditSurvey->table_survey_schedule,array_unique($insert_oac, SORT_REGULAR));
					}

					//end of bus route

					$this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/survey/edit/'.base64_encode($id));
				} else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
			}
			else {
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}		
		}
		return view('\Modules\Survey\Views\edit', $data);
	}


	public function view($id)
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}

		$id = base64_decode($id);
		$rtc_array = [];
		$ltc_array = [];


		$data = [
			'title' => 'Survey - View',
			'bus_route' => $this->customModel->getwhere_record($this->configAuditSurvey->table_bus_company,array('is_active' => '1','is_deleted' => '0')),
			'survey_template' => $this->customModel->getwhere_record($this->configAuditSurvey->table_survey_template,array('is_active' => '1','deleted' => '0')),
			'survey_types' => $this->configAuditSurvey->survey_types,
			'survey_data' => $this->customModel->get_survey($id),
			'survey_shift' => $this->customModel->getwhere_record($this->configAuditSurvey->table_survey_shift,array('survey_id' => $id)),
			'survey_bus_route' => $this->customModel->getwhere_record($this->configAuditSurvey->table_busroute_survey,array('surveys_id' => $id)),
			'survey_table_data' => $this->customModel->get_survey_table($id),
		];

		//explode bus route
		$routes = explode(',',$data['survey_data'][0]['bus_route']);

		foreach($routes as $key => $value)
		{
			$get_user_route = $this->customModel->get_coordinators($value);
			if($get_user_route[0]['code'] == ROLE_LTC)
			{
				$ltc_array[] = $get_user_route[0];
			}

			if($get_user_route[0]['code'] == ROLE_RTC)
			{
				$rtc_array[] = $get_user_route[0];
			}
		}

		$data['rtc_list'] = $rtc_array;
		$data['ltc_list'] = $ltc_array;

		return view('\Modules\Survey\Views\view', $data);
	}
}
