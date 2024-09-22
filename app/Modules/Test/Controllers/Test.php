<?php
namespace Modules\Test\Controllers;
use App\Controllers\BaseController;
use Modules\Test\Models\TestModel;
use IonAuth\Libraries\IonAuth;

class Test extends BaseController
{
	public function __construct()
	{
		$this->ionAuth = new IonAuth();
		$this->configIonAuth = config('IonAuth');
		if (!$this->ionAuth->loggedIn()) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/login');
		}
		$this->testModel = new TestModel();
	}

	public function index()
	{
		$data = [
			'title' => 'Districts',
			'records' => $this->testModel->select('*')->findAll()
		        ];
	
	    return view('\Modules\test\Views\list', $data);
	}

	public function add()
	{
        
		$data = [
			'title' => 'Districts - Add',
		];

		if ($this->request->getPost()) {
			// validate form input
			$this->validation->setRule('name','Name','required');
			$this->validation->setRule('billing_address_1', 'Billing address', 'trim|required');
			$this->validation->setRule('billing_address_2', 'Billing address', 'trim');
			$this->validation->setRule('district_web_url', 'Ditrict Website URL','required');
            $this->validation->setRule('district_code', 'Ditrict Code', 'required');

            $this->validation->setRule('city', 'City', 'required');
            $this->validation->setRule('state', 'State', 'required');


			if ($this->validation->withRequest($this->request)->run()) {
				$additionalData = [
					'district_name' => $this->request->getPost('name'),
					'billing_address1' => $this->request->getPost('billing_address_1'),
					'billing_address2' => $this->request->getPost('billing_address_2'),
			        'district_url' => $this->request->getPost('district_web_url'),
					'district_code' => $this->request->getPost('district_code'),
					'city' => $this->request->getPost('city'),
					'state' => $this->request->getPost('state'),
					'zipcode' => $this->request->getPost('zip_code'),
					'created_by'=> $this->ionAuth->user()->row()->id,
					'is_active'=> $this->request->getPost('district_status') ? : 0,
				   ];

				if ($this->schoolDistrictModel->insert($additionalData)) {
					$this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/districts');
				} else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
			} else {
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		}
		return view('\Modules\SchoolDistrict\Views\add', $data);
	}

	public function edit($id)
	{
		$id = base64_decode($id);
		$record = $this->schoolDistrictModel->select('*')->find($id);
		if (!$record) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/districts');
		}
		$data = [
			'title' => 'Districts - Edit',
			'record' => $record,
		];

		if ($this->request->getPost()) {
			$this->validation->setRule('name','Name','required');
			$this->validation->setRule('billing_address_1', 'Billing address', 'trim|required');
			$this->validation->setRule('billing_address_2', 'Billing address', 'trim');
			$this->validation->setRule('district_web_url', 'Ditrict Website URL','required');
            $this->validation->setRule('district_code', 'Ditrict Code', 'required');
	       
            $this->validation->setRule('city', 'City', 'required');
            $this->validation->setRule('state', 'State', 'required');
			if ($this->validation->withRequest($this->request)->run()) {
				
				$update_data = [
		   		    'district_name' => $this->request->getPost('name'),
					'billing_address1' => $this->request->getPost('billing_address_1'),
					'billing_address2' => $this->request->getPost('billing_address_2'),
					'district_url' => $this->request->getPost('district_web_url'),
					'district_code' => $this->request->getPost('district_code'),
					'city' => $this->request->getPost('city'),
					'state' => $this->request->getPost('state'),
					'zipcode' => $this->request->getPost('zip_code'),
				    'is_active'=> $this->request->getPost('district_status'),
				];

				if ($this->schoolDistrictModel->update($id, $update_data)) {
					$this->session->setFlashdata('success_message', 'Record Updated');
				} else {
					$this->session->setFlashdata('error_message', 'Update failed');
				}
				return redirect()->to('/districts');
			}else {
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		}

		return view('\Modules\SchoolDistrict\Views\edit', $data);
	}


	public function delete($id)
	{
		$user_id = base64_decode($id);
		$user = $this->schoolDistrictModel->select('id')->find($user_id);		
		if (!$user) {
			return redirect()->to('/districts');
		}

		$this->schoolDistrictModel->delete($user_id);
		$this->session->setFlashdata('error_message', 'Districts deleted');
		return redirect()->to('/districts');
	}


public function getListData() {
		$this->list();
	}

	public function list() {
		$data 					= [];
		$data['content_title'] 	= 'News - List'; 
		$data['status_list']	= $this->schoolDistrictModel->get_all(["is_active"=>"1"]);
		$this->load->view('list', $data);
	}

}
