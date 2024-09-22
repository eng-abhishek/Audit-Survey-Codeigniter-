<?php

namespace Modules\OacUser\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use Psr\Log\LoggerInterface;
use IonAuth\Libraries\IonAuth;
use App\Config\Email;
use Modules\OacUser\Models\OACUserModel;
use Modules\OacUser\Models\InvitesRegisterModel;
use Hermawan\DataTables\DataTable;
use Modules\User\Models\GroupModel;


class OacUsers extends BaseController
{

	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	       parent::initController($request, $response, $logger);
	       $this->isLoggedIn();
	       $this->oacInvite = new OACUserModel();
	       $this->invitesRegister = new InvitesRegisterModel();
	       $this->groupModel = new GroupModel();
	       $this->unapproved_count = $this->invitesRegister->getrecordCount();
	}

	public function index()
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}

		$error_msg = [];
		return view('\Modules\OacUser\Views\invites',array('error_msg' => $error_msg));
	}

	public function ajaxDatatables()
	{

		$builder = $this->invitesRegister->get_datatable_oac_register($this->ionAuth->user()->row()->id);
        return DataTable::of($builder)
        		->add('registration_status', function($row){
        			$status = "Inactive";
        			if($row->registration_status == '1')
        			{
        				$status = "Active";
        			}

        			if($row->registration_status == '2')
        			{
        				$status = "Rejected";
        			}
        			
        			return $status;
    			})
        		->add('action', function($row){
        			$action = '<a href="'.base_url('oac-invites/view/' . base64_encode($row->id)).'"><i class="far fa-eye"></i></a>';

        			if($row->registration_status != '1')
        			{
	        			$action .= '<a href="#" class="list_approve" data-uid="'.base64_encode($row->id).'"><i class="fa fa-check" aria-hidden="true"></i></a>';
				}


				if($row->registration_status == '0')
        			{
	        			$action .= '<a href="#" class="list_reject" data-uid="'.base64_encode($row->id).'"><i class="fa fa-times" aria-hidden="true"></i></a>';
	        		}
        			return $action;
    			})
    			->filter(function ($builder, $request) {  

            		if ($request->listsearchfilter && $request->listsearchfilter == 'registration_status')
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
            		else if($request->listsearchfilter && $request->listsearchfilter == 'name')
            		{
            			$builder->like('first_name', $request->search_value);
            			$builder->orLike('last_name', $request->search_value);
            		}
            		else
            		{
            			$builder->where($request->listsearchfilter, $request->search_value);
            		}
    			})
               ->addNumbering('no') 
               ->toJson(true);
	}

	public function invite()
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}


		$explode_email =  explode (",", $this->request->getVar('email_ids'));
		$error_msg = [];
		//check email id exist in user table
		if(!empty($explode_email))
		{

			foreach($explode_email as $key => $value) 
			{
				$get_user = $this->groupModel->getwhere_multiple($this->configAuditSurvey->table_users,array('email'=>trim($value)));

				if(!empty($get_user))
				{
					$error_msg[] = $get_user->email; 
				}
			}
		}


		if(!empty($explode_email) && empty($error_msg))
		{
			$this->validation->setRule('email_ids', 'email_ids', 'required|valid_emails|is_unique[invites.email]');

			if ($this->validation->withRequest($this->request)->run()) {
				//insert and send email
				foreach ($explode_email as $key => $value) {
					$data = array(
								'user_code' => 'OAC',
								'email' => trim($value),
								'ref_token' => generateRandomString(),
								'active' => '1',
								'invited_by' => $this->ionAuth->user()->row()->id
							);
					$this->oacInvite->insert($data);

					//sendEmail('OAC Invite email',view('Modules\OacUser\Views\invite_email', $data));
				}

				$this->session->setFlashdata('success_message', 'Invites send successfully');
				return redirect()->to('/oac-invites');
			}
			else
			{
				//return with validation error
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}
		
		return view('\Modules\OacUser\Views\invites',array('error_msg' => $error_msg));
	}


	public function listApprovals()
	{
		$data = [
			'title' => 'OAC Approval',
			'unapproved_count' => $this->unapproved_count 
		];
		return view('\Modules\OacUser\Views\list', $data);
	}


	public function view($id)
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}

		
		$invite_id = base64_decode($id);
		$record = $this->invitesRegister->select('*')->find($invite_id);

		$data = [
			'title' => 'Users - Add',
			'groups' => $this->groupModel->select('id, name, code')->where('is_active', 1)->findAll(),
			'state_master' => $this->groupModel->get_all_data($this->configAuditSurvey->table_state_master),
			'district' => $this->groupModel->get_all_data($this->configAuditSurvey->table_districts),
			'school_destinations' => $this->groupModel->get_all_data($this->configAuditSurvey->table_destination),
			'hash' => $id,
			'record' => $record,
			'unapproved_count' => $this->unapproved_count 
		];

		if ($record) 
		{
			return view('\Modules\OacUser\Views\view_user', $data);
		}
		else
		{
			return redirect()->back()->with('error_message', 'Invalid record id');
		}		
	}


	public function approveUser($id)
	{
		$id = base64_decode($id);
		if ($this->request->getPost() && $this->request->getPost('btn_type') == 'approve') {
			//check validation here
			$this->validation->setRule('districts', lang('oacuser.label_district'), 'required');
			$this->validation->setRule('school_destination_id', lang('oacuser.label_destination'), 'required');
			$this->validation->setRule('name', lang('oacuser.label_firstname'), 'required');
			$this->validation->setRule('last_name', lang('oacuser.label_lastname'), 'required');
			$this->validation->setRule('title_role', lang('oacuser.label_title'), 'required');
			$this->validation->setRule('state', lang('oacuser.label_state'), 'required');
			$this->validation->setRule('city', lang('oacuser.label_city'), 'required');
			$this->validation->setRule('ext', lang('oacuser.label_ext'), 'required');
			$this->validation->setRule('phone', lang('oacuser.label_mobile'), 'required');
			$this->validation->setRule('email', lang('oacuser.label_email'), 'trim|required|valid_email|is_unique[users.email]');
			$this->validation->setRule('address', lang('oacuser.label_address1'), 'trim|required');

			if ($this->validation->withRequest($this->request)->run()) {
				//create users here

				$userData = [
					'first_name' => $this->request->getPost('name'),
					'last_name' => $this->request->getPost('last_name'),
					'email'  => $this->request->getPost('email'),
					'group_id'=> '6',
					'address' => $this->request->getPost('address'),
					'office_address2' => $this->request->getPost('office_address'),
					'phone' => $this->request->getPost('phone'),
					'title_role' => $this->request->getPost('title_role'),
					'extension' => $this->request->getPost('ext'),
					'fax' => $this->request->getPost('fax'),
					'city' => $this->request->getPost('city'),
					'zipcode' => $this->request->getPost('zipcode'),
            				'state' => $this->request->getPost('state'),
					'created_by' => $this->ionAuth->user()->row()->id,
					'school_destination_id' => $this->request->getPost('school_destination_id'),
				];

				if($this->request->getPost('sms_survey_completion'))
				{
					$userData['sms_survey_completion'] = $this->request->getPost('sms_survey_completion');
				}

				if($this->request->getPost('sms_receive_alerts'))
				{
					$userData['sms_survey_alert'] = $this->request->getPost('sms_receive_alerts');
				}

				if($this->request->getPost('email_survey_completion'))
				{
					$userData['email_survey_completion'] = $this->request->getPost('email_survey_completion');
				}

				if($this->request->getPost('email_survey_alerts'))
				{
					$userData['email_survey_alert'] = $this->request->getPost('email_survey_alerts');
				}

				$email    = strtolower($this->request->getPost('email'));
				$identity = $email;
				$password = '123456';

				$user_register = $this->ionAuth->register($identity, $password, $email, $userData, [$userData['group_id']]);
				if ($user_register) {
					//insert into user district table
					$add_user_district = array(
						'user_id' => $user_register,
						'district_id'=>$this->request->getPost('districts'),
						'status' => '1',
						'date_created' => date('Y-m-d H:i:s')
					);

					$this->groupModel->insert_data($this->configAuditSurvey->table_users_districts,$add_user_district);
				}

				//update in register-invite table 
				$data = [
					    'user_id' => $user_register,
					    'registration_status' => '1',
					];

				$this->invitesRegister->update($id, $data);

				//send email here
				/*$email_data = array('password' => $password);
				sendEmail('Registration Approved',view('Modules\OacUser\Views\approved_email', $email_data),$this->request->getPost('email'));*/
				$this->ionAuth->setPasswordByUser($identity);


				$this->session->setFlashdata('success_message', $this->ionAuth->messages());
				return redirect()->to('/oac-invites/list-approvals');
			}
			else
			{
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}
		else if ($this->request->getPost() && $this->request->getPost('btn_type') == 'reject')
		{
			//update in register-invite table 
			$data = [
				    'registration_status' => '2',
				];

			$this->invitesRegister->update($id, $data);

			//send email here
			sendEmail('Registration Approved',view('Modules\OacUser\Views\email_templates\rejected_email'),$this->request->getPost('email'));
			$this->session->setFlashdata('success_message', $this->ionAuth->messages());
			return redirect()->to('/oac-invites/list-approvals');
		}
		else
		{

		}

		return redirect()->back()->with('error_message', $this->validation->listErrors('list'));
	}

	public function rejectOAC()
	{
		$id = base64_decode($this->request->getVar('id'));
		$record = $this->invitesRegister->select('*')->find($id);

		if($record)
		{
			$data = [
				    'registration_status' => '2',
				];

			$this->invitesRegister->update($id, $data);
			//send email here
			sendEmail('Registration Rejected',view('Modules\OacUser\Views\email_templates\rejected_email'),$record['email']);
			$return_data['status'] = 'success';
		}
		else
		{
			$return_data['status'] = 'failure';
		}

		echo json_encode($return_data);
	}


	public function approveOAC()
	{
		$id = base64_decode($this->request->getVar('id'));
		$record = $this->invitesRegister->select('*')->find($id);

		if($record)
		{
			//create users here
			$userData = [
				'first_name' => $record['first_name'],
				'last_name' => $record['last_name'],
				'email'  => $record['email'],
				'group_id'=> '6',
				'address' => $record['office_address1'],
				'office_address2' => $record['office_address2'],
				'phone' => $record['phone'],
				'title_role' => $record['title_role'],
				'extension' => $record['extension'],
				'fax' => $record['fax'],
				'city' => $record['city'],
				'zipcode' => $record['zipcode'],
     				'state' => $record['state'],
				'created_by' => $this->ionAuth->user()->row()->id,
				'school_destination_id' => $record['school_destination_id'],
			];

			if($record['sms_survey_completion'])
			{
				$userData['sms_survey_completion'] = $record['sms_survey_completion'];
			}

			if($record['sms_survey_alert'])
			{
				$userData['sms_survey_alert'] = $record['sms_survey_alert'];
			}

			if($record['email_survey_completion'])
			{
				$userData['email_survey_completion'] = $record['email_survey_completion'];
			}

			if($record['email_survey_alert'])
			{
				$userData['email_survey_alert'] = $record['email_survey_alert'];
			}

			$email    = strtolower($record['email']);
			$identity = $email;
			$password = '123456';

			$user_register = $this->ionAuth->register($identity, $password, $email, $userData, [$userData['group_id']]);
			if ($user_register) {
				//insert into user district table
				$add_user_district = array(
					'user_id' => $user_register,
					'district_id'=>$record['school_district_id'],
					'status' => '1',
					'date_created' => date('Y-m-d H:i:s')
				);

				$this->groupModel->insert_data($this->configAuditSurvey->table_users_districts,$add_user_district);
			

				//update in register-invite table 
				$data = [
					    'user_id' => $user_register,
					    'registration_status' => '1',
					];

				$this->invitesRegister->update($id, $data);

				//send email here
				$this->ionAuth->setPasswordByUser($identity);
				$return_data['status'] = 'success';
			}
			else
			{
				$return_data['status'] = 'failure';
			}
			
					
		}
		else
		{
			$return_data['status'] = 'failure';
		}

		echo json_encode($return_data);
	}
}
