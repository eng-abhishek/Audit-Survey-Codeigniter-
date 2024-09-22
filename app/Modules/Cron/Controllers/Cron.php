<?php

namespace Modules\Cron\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use Psr\Log\LoggerInterface;
use Modules\Cron\Models\CustomModel;
use App\Config\Email;


class Cron extends BaseController
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	    parent::initController($request, $response, $logger);
		$this->customModel = new CustomModel();
	}

	
	public function index()
	{
		
	}

	public function oacInviteEmailCron()
	{
		$records = $this->customModel->getwhere_record('invites',array('is_email_sent' => NOT_ACTIVE_STATUS));

		if($records)
		{
			foreach($records as $key => $record)
			{
				$data['ref_token'] = $record['ref_token'];
				sendEmail('OAC Invite email',view('Modules\OacUser\Views\invite_email', $data));
				$this->customModel->update_where('invites',array('is_email_sent' => ACTIVE_STATUS),array('id' => $record['id']));
			}
			die();
		}
	}
}
