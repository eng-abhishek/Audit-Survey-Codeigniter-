<?php

namespace Modules\User\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use Modules\User\Models\UserModel;
use Modules\User\Models\GroupModel;
use IonAuth\Libraries\IonAuth;
use Hermawan\DataTables\DataTable;


class Users extends BaseController
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	        parent::initController($request, $response, $logger);
	        if (!$this->ionAuth->loggedIn()) {
						return redirect()->to('/login');
					}

			$this->userModel = new UserModel();
			$this->groupModel = new GroupModel();
	}

	public function index()
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}

		$data = [
			'title' => 'Users',
			'records' => $this->userModel->getlistview()
		];
		return view('\Modules\User\Views\user_list', $data);
	}

	public function dashboard()
	{
		return view('\Modules\User\Views\dashboard');
	}


	/*
	* function is to populate data to datatable in list view
	*/
    public function ajaxDatatables()
	{
		$builder = $this->userModel->get_datatable($this->configAuditSurvey->table_survey_template,$this->ionAuth->user()->row()->id);
        return DataTable::of($builder)
        		->add('active', function($row){
        			if($row->active == '1')
        			{
        				$status = 'Active';
        			}
        			else
        			{
        				$status = 'Inactive';
        			}
        			
        			return $status;
    			})
        		->add('action', function($row){
        			
        			$action = '<a href="'.base_url("users/edit/" . base64_encode($row->userid)).'"><i class="fas fa-edit btnedit"></i></a>';

    				if($row->active == '1'){
                      	$val="checked";
                      }	else{
                      	$val="";
                      }

    			    $action .=  '<td>
                        <div class="custom-control custom-switch">
                        	<input type="checkbox" data-uid="'.$row->userid.'" class="custom-control-input listaction" name="status'.$row->userid.'" value="'.$row->active.'" id="status'.$row->userid.'"'.$val.'>
                        	<label class="custom-control-label" for="status'.$row->userid.'"></label>
                        </div>
                        </td>';

        			$action .= '<a href="'.base_url('users/view/' . base64_encode($row->userid)).'"><i class="fas fa-eye btnview"></i></a>';

        			if($this->ionAuth->user()->row()->group_id == GROUP_SA)
        			{
        				$action .= '<a href="#" class="delete-user btndelete" data-id="'.base64_encode($row->userid).'"><i class="fas fa-trash"></i></a>';
        			}
        			return $action;
    			})
    			->filter(function ($builder, $request) {
        			if ($request->listsearchfilter && $request->listsearchfilter == 'first_name')
        			{
            			$builder->where("CONCAT(first_name, ' ', last_name) LIKE '%".$request->search_value."%'", NULL, FALSE);
        			}

            		if ($request->listsearchfilter && $request->listsearchfilter == 'email')
            			$builder->where($request->listsearchfilter, $request->search_value);

            		if ($request->listsearchfilter && $request->listsearchfilter == 'phone')
            			$builder->where($request->listsearchfilter, $request->search_value);

            		if ($request->listsearchfilter && $request->listsearchfilter == 'code')
            			$builder->where($request->listsearchfilter, $request->search_value);

					if ($request->listsearchfilter && $request->listsearchfilter == 'title_role')
            			$builder->where($request->listsearchfilter, $request->search_value);

            		if ($request->listsearchfilter && $request->listsearchfilter == 'district_name')
            			$builder->where($request->listsearchfilter, $request->search_value);


            		if ($request->listsearchfilter && $request->listsearchfilter == 'active')
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


	/*
	* add - function is create user
	@table - insertion done in users,user_staffs_mapping,user_groups,user_districts
	@process -  if RTC,LTC data not insert in 'user_staffs_mapping' table
	@process - email send to users
	@view file - user_add.php
	*/
	public function add()
	{
		
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}

		$data = [
			'title' => 'Users - Add',
			'groups' => $this->groupModel->select('id, name, code')->where('is_active', 1)->findAll(),
			'state_master' => $this->groupModel->get_all_data($this->configAuditSurvey->table_state_master),
			'district' => $this->groupModel->get_all_data($this->configAuditSurvey->table_districts),
			'school_destinations' => $this->groupModel->get_all_data($this->configAuditSurvey->table_destination),
			'current_user' => $this->ionAuth->user()->row(),
			'currentGroups' => $this->ionAuth->getUsersGroups($this->ionAuth->user()->row()->id)->getResult()

		];


		$tables                        = $this->configIonAuth->tables;
		$identityColumn                = $this->configIonAuth->identity;
		$this->data['identity_column'] = $identityColumn;
		if ($this->request->getPost()) {
			// validate form input
			//$this->validation->setRule('districts', 'district', 'required');
			$this->validation->setRule('name', str_replace(':', '', lang('Auth.create_user_validation_name_label')), 'alpha_space|required');
			$this->validation->setRule('last_name', 'Last Name', 'alpha_space|trim|required');
			$this->validation->setRule('title_role', 'Title/Role', 'trim|required');
			$this->validation->setRule('city', 'city', 'trim|required');
			$this->validation->setRule('zipcode', 'zipcode', 'trim|required');
			$this->validation->setRule('email', lang('Auth.create_user_validation_email_label'), 'trim|required|valid_email');
			$this->validation->setRule('phone', lang('Auth.create_user_validation_phone_label'), 'trim|required');
			$this->validation->setRule('address', lang('Auth.create_user_validation_address_label'), 'trim|required');

			/* Validation if user is RTC */
			if($this->request->getPost('group_id') == 2)
			{
				$this->validation->setRule('organization_name', 'Organization Name', 'required');
				$this->validation->setRule('billing_address_1', 'Billing address', 'required');
				$this->validation->setRule('billing_state', 'Billing State', 'required');
				$this->validation->setRule('billing_city', 'Billing City', 'required');

				if($this->request->getPost('website_url') != '')
				{
					$this->validation->setRule('website_url', 'Website URL', 'valid_url');
				}
			}

			if($this->request->getPost('group_id') == 6)
			{
				$this->validation->setRule('school_destination_id', 'School destination', 'required');
			}

			if ($this->validation->withRequest($this->request)->run()) {
				$email    = strtolower($this->request->getPost('email'));
				$identity = ($identityColumn === 'email') ? $email : $this->request->getPost('identity');
				$password = '123456'; //$this->request->getPost('password');

				
				$additionalData = [
					'first_name' => trim($this->request->getPost('name')),
					'last_name' => trim($this->request->getPost('last_name')),
					'email'  => $email,
					//'group_id'=> $this->request->getPost('group_id'),
					'address' => trim($this->request->getPost('address')),
					'office_address2' => trim($this->request->getPost('office_address')),
					'phone' => trim($this->request->getPost('phone')),
					'title_role' => trim($this->request->getPost('title_role')),
					'fax' => trim($this->request->getPost('fax')),
					'city' => trim($this->request->getPost('city')),
					'zipcode' => trim($this->request->getPost('zipcode')),
          'state' => $this->request->getPost('state'),
					'created_by' => $this->ionAuth->user()->row()->id
				];

				if($data['currentGroups'][0]->code == ROLE_LTC)
				{
					$parent_user_id = $this->ionAuth->user()->row()->id;
					$additionalData['group_id'] = 5;
				}
				else if($data['currentGroups'][0]->code == ROLE_RTC)
				{
					$parent_user_id = $this->ionAuth->user()->row()->id;
					$additionalData['group_id'] = 3;
				}
				else if($data['currentGroups'][0]->code == ROLE_OAC)
				{
					$parent_user_id = $this->ionAuth->user()->row()->id;
					$additionalData['group_id'] = 7;
				}
				else
				{
					$parent_user_id = $this->request->getPost('parent_user_id');
					$additionalData['group_id'] = $this->request->getPost('group_id');
				}

				if($additionalData['group_id'] == 2)
				{
						$additionalData['organization_name'] = trim($this->request->getPost('organization_name'));
						$additionalData['billing_address_1'] = trim($this->request->getPost('billing_address_1'));
						$additionalData['billing_address_2'] = trim($this->request->getPost('billing_address_2'));
						$additionalData['website_url']  = trim($this->request->getPost('website_url'));
						$additionalData['billing_state']  = $this->request->getPost('billing_state');
						$additionalData['billing_city']  = trim($this->request->getPost('billing_city'));
						$additionalData['billing_zipcode']  = trim($this->request->getPost('billing_zipcode'));
				}


				if($additionalData['group_id'] == 6)
				{
						$additionalData['school_destination_id'] = $this->request->getPost('school_destination_id');
				}

				if($this->request->getPost('sms_survey_completion'))
				{
					$additionalData['sms_survey_completion'] = $this->request->getPost('sms_survey_completion');
				}

				if($this->request->getPost('sms_receive_alerts'))
				{
					$additionalData['sms_survey_alert'] = $this->request->getPost('sms_receive_alerts');
				}

				if($this->request->getPost('email_survey_completion'))
				{
					$additionalData['email_survey_completion'] = $this->request->getPost('email_survey_completion');
				}

				if($this->request->getPost('email_survey_alerts'))
				{
					$additionalData['email_survey_alert'] = $this->request->getPost('email_survey_alerts');
				}

				if($this->request->getPost('active'))
				{
					$additionalData['active'] = $this->request->getPost('active');
				}
			

				$user_register = $this->ionAuth->register($identity, $password, $email, $additionalData, [$additionalData['group_id']]);
				if ($user_register) {
					//insert into relationship table -- user district
					if($this->request->getPost('districts'))
					{
						foreach($this->request->getPost('districts') as $option)
						{
							$option_list_default_question[] = array(
								'user_id' => $user_register,
								'district_id' => $option,
								'status' => '1',
								'date_created' => date('Y-m-d H:i:s')
							);
						}

						// insert into district table
						$this->groupModel->insert_batch('user_districts',$option_list_default_question);
					}

					// insert into user mapping table
					if($parent_user_id)
					{
						$insert_data = array('parent_user_id' => $parent_user_id,'user_id' => $user_register,'status' => '1','created_at' => date('Y-m-d H:i:s'));
						$this->groupModel->insert_data($this->configAuditSurvey->table_users_mapping,$insert_data);
					}

					//add district id based on user role
					if($additionalData['group_id'] == 7)
					{
						$get_parent_district =  $this->groupModel->getwhere_multiple($this->configAuditSurvey->table_users_districts,array('user_id' => $parent_user_id,'status' => '1'));

						//insert into district
						if($get_parent_district)
						{
							$option_list_default_question = array(
								'user_id' => $user_register,
								'district_id' => $get_parent_district->district_id,
								'status' => '1',
								'date_created' => date('Y-m-d H:i:s')
							);

							$this->groupModel->insert_data($this->configAuditSurvey->table_users_districts,$option_list_default_question);
						}
					}


					$this->ionAuth->setPasswordByUser($identity);

					$this->session->setFlashdata('success_message', $this->ionAuth->messages());
					return redirect()->to('/users');
				} else {
					$this->session->setFlashdata('error_message', $this->ionAuth->errors('list'));
				}
			} else {
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}

		return view('\Modules\User\Views\user_add', $data);
	}

	/*
	@purpose  - This function is to edit the user.
	@parameters - id 
	@view file - user_edit.php
	*/
	public function edit($id)
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}


		$user_id = base64_decode($id);

		//get user type
		$user = $this->ionAuth->user($user_id)->row();
		if($user->group_id == '7')
		{
			$userData = $this->userModel->getoasuserdata($user_id);
		}
		else
		{
			$userData = $this->userModel->getuserdata($user_id);	
		}
		
		$user = array();
		foreach($userData as $key => $value)
		{
			if($key == 0)
			{
				$district_id = '';
				foreach($value as $ukey => $uvalue)
				{
					if($ukey == 'district_id')
					{
						$district_id = $uvalue;	
					}

					if($ukey != 'district_name')
					{
						$user[$ukey] = $uvalue;	
					}
					else
					{
						$user[$ukey][$district_id] = $uvalue;	
					}
				}	
			}
			else
			{
				$district_id = '';
				foreach($value as $ukey => $uvalue)
				{
					if($ukey == 'district_id')
					{
						$district_id = $uvalue;	
					}

					if($ukey == 'district_name')
					{
						$user[$ukey][$district_id] = $uvalue;	
					}
				}	
			}
			
		}
		if (!$user) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/users');
		}
		$data = [
			'title' => 'Users - Edit',
			'user' => $user,
			'groups'	=> $this->ionAuth->groups()->result(),
			'district' => $this->groupModel->get_all_data($this->configAuditSurvey->table_districts),
			'state_master' => $this->groupModel->get_all_data($this->configAuditSurvey->table_state_master),
			'school_destinations' => $this->groupModel->get_all_data($this->configAuditSurvey->table_destination),
			'current_user' => $this->ionAuth->user()->row(),
			'currentGroups' => $this->ionAuth->getUsersGroups($this->ionAuth->user()->row()->id)->getResult()
			//'currentGroups' => $this->ionAuth->getUsersGroups($user_id)->getResult()
		];
		if ($this->request->getPost()) {
			$this->validation->setRule('name', lang('Auth.edit_user_validation_fname_label'), 'alpha_space|required');
			$this->validation->setRule('last_name', 'Last Name', 'alpha_space|trim|required');
			$this->validation->setRule('title_role', 'Title/Role', 'trim|required');
			$this->validation->setRule('city', 'city', 'trim|required');
			$this->validation->setRule('zipcode', 'zipcode', 'trim|required');
			$this->validation->setRule('address', lang('Auth.edit_user_validation_address_label'), 'trim|required');
			$this->validation->setRule('phone', lang('Auth.edit_user_validation_phone_label'), 'trim|required');
			if($this->request->getPost('group_id') == 6)
			{
				$this->validation->setRule('school_destination_id', 'School destination', 'required');
			}
			/* Validation if user is RTC */
			if($this->request->getPost('group_id') == 2)
			{
				$this->validation->setRule('organization_name', 'Organization Name', 'required');
				$this->validation->setRule('billing_address_1', 'Billing address', 'required');
				$this->validation->setRule('billing_state', 'Billing State', 'required');
				$this->validation->setRule('billing_city', 'Billing City', 'required');
				if($this->request->getPost('website_url') != '')
				{
					$this->validation->setRule('website_url', 'Website URL', 'valid_url');
				}
			}


			if ($this->validation->withRequest($this->request)->run()) {
				$email    = strtolower($this->request->getPost('email'));
				$update_data = [
					'first_name' => trim($this->request->getPost('name')),
					'last_name' => trim($this->request->getPost('last_name')),
					'email'  => $email,
					'address' => trim($this->request->getPost('address')),
					'office_address2' => trim($this->request->getPost('office_address')),
					'phone' => trim($this->request->getPost('phone')),
					'title_role' => trim($this->request->getPost('title_role')),
					'fax' => trim($this->request->getPost('fax')),
					'city' => trim($this->request->getPost('city')),
					'zipcode' => trim($this->request->getPost('zipcode')),
            		'state' => $this->request->getPost('state'),
				];


				if($this->request->getPost('group_id') == 2)
				{
					$update_data['organization_name'] = trim($this->request->getPost('organization_name'));
					$update_data['billing_address_1'] = trim($this->request->getPost('billing_address_1'));
					$update_data['billing_address_2'] = trim($this->request->getPost('billing_address_2'));
					$update_data['website_url']  = trim($this->request->getPost('website_url'));
					$update_data['billing_state']  = $this->request->getPost('billing_state');
					$update_data['billing_city']  = trim($this->request->getPost('billing_city'));
					$update_data['billing_zipcode']  = trim($this->request->getPost('billing_zipcode'));
				}

				if($this->request->getPost('group_id') == 6)
				{
						$update_data['school_destination_id'] = $this->request->getPost('school_destination_id');
				}
				

				if($this->request->getPost('sms_survey_completion'))
				{
					$update_data['sms_survey_completion'] = $this->request->getPost('sms_survey_completion');
				}
				else
				{
					$update_data['sms_survey_completion'] = '0';
				}

				if($this->request->getPost('sms_receive_alerts'))
				{
					$update_data['sms_survey_alert'] = $this->request->getPost('sms_receive_alerts');
				}
				else
				{
					$update_data['sms_survey_alert'] = '0';
				}

				if($this->request->getPost('email_survey_completion'))
				{
					$update_data['email_survey_completion'] = $this->request->getPost('email_survey_completion');
				}
				else
				{
					$update_data['email_survey_completion'] = '0';
				}

				if($this->request->getPost('email_survey_alerts'))
				{
					$update_data['email_survey_alert'] = $this->request->getPost('email_survey_alerts');
				}
				else
				{
					$update_data['email_survey_alert'] = '0';
				}


				if($this->request->getPost('active'))
				{
					$update_data['active'] = $this->request->getPost('active');
				}
				else
				{
					$update_data['active'] = '0';
				}

				if ($this->ionAuth->update($user_id, $update_data)) {

					if($user['group_id'] != '7')
                    {
						$this->groupModel->update_global(array('user_id' => $data['user']['userid']),$this->configAuditSurvey->table_users_districts,array('status' => 0));

					
						foreach($this->request->getPost('districts') as $option)
						{
							$key = array_search($option,$data['user']['district_name']);
							if(!empty($key))
							{
								$option_list_default_question = array(
									'district_id' => $option,
									'status' => '1'
								);

								$this->groupModel->update_data($key,$this->configAuditSurvey->table_users_districts,$option_list_default_question);
							}
							else
							{
								$option_list_default_question = array(
									'user_id' => $data['user']['userid'],
									'district_id' => $option,
									'status' => '1',
									'date_created' => date('Y-m-d H:i:s')
								);

								$this->groupModel->insert_data($this->configAuditSurvey->table_users_districts,$option_list_default_question);
							}
						}
					}

					if($data['currentGroups'][0]->code == ROLE_SA)
					{
						$parent_user_id = $this->request->getPost('parent_user_id');
					}
					else
					{
						$parent_user_id = $this->ionAuth->user()->row()->id;
					}

					//update parent user id
					$user_group = array(3,5,7);
					if (in_array($this->request->getPost('group_id'), $user_group))
					{
						$parent_user_update = array(
									'parent_user_id' => $parent_user_id
								);
						$affected_row = $this->groupModel->update_data_where($this->configAuditSurvey->table_users_mapping,$parent_user_update,array('user_id' => $user_id));
					}

					//add district id based on user role
					if($this->request->getPost('group_id') == 7)
					{
						$get_parent_district =  $this->groupModel->getwhere_multiple($this->configAuditSurvey->table_users_districts,array('user_id' => $parent_user_id,'status' => '1'));

						//insert into district
						if($get_parent_district)
						{
							$update_districts = array(
								'district_id' => $get_parent_district->district_id,
								'status' => '1',
							);

							$this->groupModel->update_data_where($this->configAuditSurvey->table_users_districts,$update_districts,array(								'user_id' => $user_id));
						}
					}

					$this->session->setFlashdata('success_message', $this->ionAuth->messages());
				} else {
					$this->session->setFlashdata('error_message', $this->ionAuth->errors('list'));
				}
				return redirect()->to('/users');
			}
			else {
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}
		return view('\Modules\User\Views\user_edit', $data);
	}

	/*
	@purpose  - This function is to view the user.
	@parameters - id 
	@view file - user_view.php
	*/

	public function view($id)
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}


		$user_id = base64_decode($id);
		$user = $this->ionAuth->user($user_id)->row();

		$user = $this->ionAuth->user($user_id)->row();
		if($user->group_id == '7')
		{
			$userData = $this->userModel->getoasuserdata($user_id);
		}
		else
		{
			$userData = $this->userModel->getuserdata($user_id);	
		}
		
		$user = array();
		foreach($userData as $key => $value)
		{
			if($key == 0)
			{
				$district_id = '';
				foreach($value as $ukey => $uvalue)
				{
					if($ukey == 'district_id')
					{
						$district_id = $uvalue;	
					}

					if($ukey != 'district_name')
					{
						$user[$ukey] = $uvalue;	
					}
					else
					{
						$user[$ukey][$district_id] = $uvalue;	
					}
				}	
			}
			else
			{
				$district_id = '';
				foreach($value as $ukey => $uvalue)
				{
					if($ukey == 'district_id')
					{
						$district_id = $uvalue;	
					}

					if($ukey == 'district_name')
					{
						$user[$ukey][$district_id] = $uvalue;	
					}
				}	
			}
			
		}

		if (!$user) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/users');
		}
		/*$data = [
			'title' => 'Users - View',
			'user' => $user,
			'created_by' => '',//$this->userModel->select('name')->find($user->created_by),
			'groups'	=> $this->ionAuth->groups()->resultArray(),
			'currentGroups' => $this->ionAuth->getUsersGroups($user_id)->getResult(),
			'user_districts' => $this->userModel->getUserDistrict($user_id)
		];*/

		$data = [
			'title' => 'Users - View',
			'user' => $user,
			'groups'	=> $this->ionAuth->groups()->result(),
			'district' => $this->groupModel->get_all_data($this->configAuditSurvey->table_districts),
			'state_master' => $this->groupModel->get_all_data($this->configAuditSurvey->table_state_master),
			'school_destinations' => $this->groupModel->get_all_data($this->configAuditSurvey->table_destination),
			'current_user' => $this->ionAuth->user()->row(),
			'currentGroups' => $this->ionAuth->getUsersGroups($this->ionAuth->user()->row()->id)->getResult()
			//'currentGroups' => $this->ionAuth->getUsersGroups($user_id)->getResult()
		];
		return view('\Modules\User\Views\user_view', $data);
	}

	/*
	@purpose  - This function is to Delete the user.
	@parameters - id 
	*/
	public function delete($id)
	{
		if (!$this->ionAuth->loggedIn()) {
			return redirect()->to('/login');
		}


		$user_id = base64_decode($id);
		$user = $this->userModel->select('id')->find($user_id);
		if (!$user) {
			return redirect()->to('/users');
		}
		$data = [
			'is_deleted'    => 1,
			'deleted_at'	=> date('Y-m-d H:i:s')
		];

		$this->userModel->update_data($user_id, $this->configAuditSurvey->table_users, $data);
		$this->session->setFlashdata('error_message', 'User deleted');
		return redirect()->to('/users');
	}


	/*
	@purpose  - This function is to get the user based on the group id.
	@parameters - id 
	@return - if record exist, return record else null
	*/
	public function getusers($id)
	{
		
		$get_users = $this->userModel->getwhere_record($this->configAuditSurvey->table_users,array('group_id' => $id,'is_deleted' => '0','active' => '1'));
		echo json_encode($get_users);
	}

	/*
	@purpose  - This function is to get the school destination of users.
	@parameters - id 
	@return - if record exist, return record else null
	*/
	public function getschooldestination($id)
	{
		$get_users = $this->userModel->getUserSchoolDestination($id);

		echo json_encode($get_users);
	}

	/*
	@purpose  - This function is to get the districts of users.
	@parameters - id 
	@table - user_districts,users
	@return - if record exist, return record else null
	*/
	public function getuserdistricts($id)
	{
		$get_users_districts = $this->userModel->getUserDistricts($id);

		echo json_encode($get_users_districts);
	}

	/*
	@purpose  - This function is to get all the districts.
	@table - school_districts
	@return - if record exist, return record else null
	*/
	public function getalldistricts()
	{
		$get_districts = $this->groupModel->getwhere_data($this->configAuditSurvey->table_districts,'is_deleted','0');

		echo json_encode($get_districts);
	}

	/*
	@purpose  - This function is to update the status of user.
	@parameters - id 
	@method - post
	@table - users
	@function call - on list view, status field change 
	*/
	public function update_status(){
		$get_status_response = $this->groupModel->update_data_where($this->configAuditSurvey->table_users,array('active' => $this->request->getVar('status')),array('id' => $this->request->getVar('id')));

		echo json_encode($get_status_response);
    }

    /*
	@purpose  - This function is to check the email id exist in table.
	@method - post
	@table - users
	@function call - add and edit view, on change email field
	*/
    public function check_email_exist(){

        $get_status_response = $this->groupModel->getwhere_data($this->configAuditSurvey->table_users,'email',$this->request->getVar('email'));

        if(!empty($get_status_response)){
            echo 'false';
        }
        else{
            echo 'true';
        }
    }

}
