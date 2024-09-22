<?php

namespace Modules\Student\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use IonAuth\Libraries\IonAuth;
use Modules\Student\Models\StudentModel;
use Hermawan\DataTables\DataTable;


class Student extends BaseController
{

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	       parent::initController($request, $response, $logger);
	       $this->isLoggedIn();
	     
		$this->studentModel = new StudentModel();
	}
	
	public function index()
	{
		$data = [
			'title' => 'Student',
			'records' => $this->studentModel->where('is_deleted', 0)->findAll()

		];
		return view('\Modules\Student\Views\list_survey', $data);
	}

	public function ajaxDatatables()
	{
		/*$builder = $this->surveytemplateModel->get_datatable($this->configAuditSurvey->table_survey_template);
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
        			$surveycount = "2";
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
               ->toJson(true);*/
	}


	public function add()
	{
		$data = [
			'title' => 'Student- Add',
			'state_master' => $this->studentModel->get_all_data($this->configAuditSurvey->table_state_master)
		];

		if ($this->request->getPost()) {


			// validate form input
			$this->validation->setRule('firstname', 'First Name', 'required');
			$this->validation->setRule('lastname', 'Last Name', 'required');
			$this->validation->setRule('address1', 'Home Address 1', 'required');
			$this->validation->setRule('state', 'state', 'required');
			$this->validation->setRule('city', 'city', 'required');
			$this->validation->setRule('zipcode', 'zipcode', 'required');
			$this->validation->setRule('district_code', 'district code', 'required');
			$this->validation->setRule('email', 'email', 'required|valid_email|is_unique[students.email_id]');

			if ($this->validation->withRequest($this->request)->run()) 
			{
				$postData = [
					'first_name' => $this->request->getPost('firstname'),
					'last_name' 	=> $this->request->getPost('lastname'),
					'student_state_id' 	=> $this->request->getPost('state_id'),
					'address1' 	=> $this->request->getPost('address1'),
					'address2' => $this->request->getPost('address2'),
					'city' 	=> $this->request->getPost('city'),
					'state' 	=> $this->request->getPost('state'),
					'email_id' 	=> $this->request->getPost('email'),
					'emergency_contact_title' =>  $this->request->getPost('title'),
				];

				if ($this->studentModel->insert($postData)) {
					$this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/student/add');
				} else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
			}
			else {
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}
		return view('\Modules\Student\Views\add_student', $data);

	}

	public function edit($id)
	{
		
	}


	public function delete($id)
	{
		
	}

}
