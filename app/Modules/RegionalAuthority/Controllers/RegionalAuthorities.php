<?php

namespace Modules\RegionalAuthority\Controllers;

use App\Controllers\BaseController;
use Modules\RegionalAuthority\Models\RegionalAuthorityModel;
use IonAuth\Libraries\IonAuth;

class RegionalAuthorities extends BaseController
{
	public function __construct()
	{
		$this->ionAuth = new IonAuth();
		$this->configIonAuth = config('IonAuth');
		if (!$this->ionAuth->loggedIn()) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/login');
		}
		$this->regionalAuthorityModel = new RegionalAuthorityModel();
	}

	public function index()
	{

		$data = [
			'title' => 'Regional Authorities',
			'records' => $this->regionalAuthorityModel->select('id, name, created_by, is_active')->findAll()

		];
		return view('\Modules\RegionalAuthority\Views\list', $data);
	}

	public function add()
	{
		$data = [
			'title' => 'Regional Authorities - Add',
		];
		if ($this->request->getPost()) {
			// validate form input
			$this->validation->setRule('name', str_replace(':', '', 'Name'), 'required');
			$this->validation->setRule('billing_address', 'Billing address', 'trim|required');
			if ($this->validation->withRequest($this->request)->run()) {
				$additionalData = [
					'name' 			=> $this->request->getPost('name'),
					'billing_address' => $this->request->getPost('billing_address'),
					'created_by'	=> $this->ionAuth->user()->row()->id
				];
				if ($this->regionalAuthorityModel->insert($additionalData)) {
					$this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/regional-authorities');
				} else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
			} else {
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		}
		return view('\Modules\RegionalAuthority\Views\add', $data);
	}

	public function edit($id)
	{
		$id = base64_decode($id);
		$record = $this->regionalAuthorityModel->select('name, billing_address, created_by, is_active')->find($id);
		if (!$record) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/regional-authorities');
		}
		$data = [
			'title' => 'Regional Authorities - Edit',
			'record' => $record,
		];
		if ($this->request->getPost()) {
			$this->validation->setRule('name', 'Name', 'trim|required');
			$this->validation->setRule('billing_address', 'Billing address', 'trim|required');
			if ($this->validation->withRequest($this->request)->run()) {
				$update_data = [
					'name' => $this->request->getPost('name'),
					'billing_address'  => $this->request->getPost('billing_address'),
				];
				if ($this->regionalAuthorityModel->update($id, $update_data)) {
					$this->session->setFlashdata('success_message', 'Record Updated');
				} else {
					$this->session->setFlashdata('error_message', 'Update failed');
				}
				return redirect()->to('/regional-authorities');
			}else {
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		}

		return view('\Modules\RegionalAuthority\Views\edit', $data);
	}

	public function delete($id)
	{
		$user_id = base64_decode($id);
		$user = $this->userModel->select('id, name, is_active')->find($user_id);
		if (!$user) {
			return redirect()->to('/regional-authorities');
		}
		$data = [
			'id' => $user_id,
			'is_deleted'    => 1,
			'deleted_at'	=> date('Y-m-d H:i:s')
		];
		$this->userModel->update($id, $data);
		$this->session->setFlashdata('error_message', 'User deleted');
		return redirect()->to('/regional-authorities');
	}
}
