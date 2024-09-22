<?php

namespace Modules\Schoolemail\Controllers;

use App\Controllers\BaseController;
use IonAuth\Libraries\IonAuth;
use App\Config\Email;

class Schoolemails extends BaseController
{
	public function __construct()
	{
		$this->ionAuth = new IonAuth();
		$this->configIonAuth = config('IonAuth');
		if (!$this->ionAuth->loggedIn()) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/login');
		}
		//$this->userModel = new UserModel();
	}

	public function index()
	{
        $email = \Config\Services::email();
		$to='karthik.hbk24@gmail.com';
		$subject='fdgsdfg';
		$message='fdgsdfg';
        $email->setTo($to);
        $email->setFrom('g2tslocaltest@gmail.com', 'Confirm Registration');
        
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) 
		{
            echo 'Email successfully sent';
        } 
		else 
		{
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
	}
}
