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
use Modules\User\Models\GroupModel;
use Modules\SchoolDestination\Models\SchoolDestinationModel;


class OacUserRegister extends BaseController
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	       parent::initController($request, $response, $logger);
	      
	       $this->oacInvite = new OACUserModel();
	       $this->invitesRegister = new InvitesRegisterModel();
	       $this->groupModel = new GroupModel();
	       $this->schoolDestination = new SchoolDestinationModel();

	}

	public function inviteRegister($hash)
	{
		$data = [
			'title' => 'Users - Add',
			'groups' => $this->groupModel->select('id, name, code')->where('is_active', 1)->findAll(),
			'state_master' => $this->groupModel->get_all_data($this->configAuditSurvey->table_state_master),
			'district' => $this->groupModel->getwhere_data($this->configAuditSurvey->table_districts,'is_deleted','0'),
			'hash' => $hash,
			'school_destinations' => $this->schoolDestination->where('is_active', 1)->where('is_deleted', 0)->findAll()
		];
		$invites = $this->oacInvite->where('ref_token', $hash)->findAll();
		
		if ($this->request->getPost() && !empty($invites)) {
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
			$this->validation->setRule('email', lang('oacuser.label_email'), 'trim|required|valid_email');
			$this->validation->setRule('address', lang('oacuser.label_address1'), 'trim|required');

			if ($this->validation->withRequest($this->request)->run()) {
				//insert here
				$sms_notification = $this->request->getVar('sms_survey_completion') ? $this->request->getVar('sms_survey_completion') : "0";
				$insert_data = array(
					'invite_id' => $invites[0]['id'],
					'invited_by' => $invites[0]['invited_by'],
					'school_district_id' => $this->request->getVar('districts'),
					'school_destination_id' => $this->request->getVar('school_destination_id'),
					'first_name' => trim($this->request->getVar('name')),
					'last_name' => trim($this->request->getVar('last_name')),
					'title_role' => trim($this->request->getVar('title_role')),
					'office_address1' => trim($this->request->getVar('address')),
					'office_address2' => trim($this->request->getVar('office_address')),
					'city' => trim($this->request->getVar('city')),
					'state' => $this->request->getVar('state'),
					'zipcode' => trim($this->request->getVar('zipcode')),
					'phone' => trim($this->request->getVar('phone')),
					'extension' => trim($this->request->getVar('ext')),
					'fax' => trim($this->request->getVar('fax')),
					'email' => trim($this->request->getVar('email')),
					'registration_status' => '0',
					'sms_survey_completion' => $sms_notification,
					'sms_survey_alert' => $this->request->getVar('sms_receive_alerts') ? $this->request->getVar('sms_receive_alerts') : "0",
					'email_survey_completion' => $this->request->getVar('email_survey_completion') ? $this->request->getVar('email_survey_completion') : "0",
					'email_survey_alert' => $this->request->getVar('email_survey_alerts') ? $this->request->getVar('email_survey_alerts') : "0"
				);

				$this->invitesRegister->insert($insert_data);

				//update in register-invite table 
				$update_invite = ['status' => '1'];
				$this->oacInvite->update($invites[0]['id'], $update_invite);

				$this->session->setFlashdata('success_message', 'Registered Successfully');
				return redirect()->to('/oac-invites/register-success');
			}
			else
			{
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}
		else
		{
			if(empty($invites))
			{
				//no record throw error
				$data['message'] = 'Invalid url';
				return view('\Modules\OacUser\Views\messages\messages',$data);
			}
			else
			{
				//check already registered
				if($invites[0]['status'] == '0')
				{
					$data['email'] = $invites[0]['email'];
					//show form
					return view('\Modules\OacUser\Views\oac_add',$data);
				}
				else
				{
					//show already registered template
					$data['message'] = 'Already Registered';
					return view('\Modules\OacUser\Views\messages\messages',$data);
				}
			}
		}
	}

	public function registrationSuccess()
	{
		echo "success, once approve or reject by user you will get notification";
	}

	public function check_email_exist()
	{
		$get_user = $this->groupModel->getwhere_multiple($this->configAuditSurvey->table_users,array('email'=>$this->request->getVar('email_id')));

		echo json_encode($get_user);
	}
}
