<?php

namespace Modules\BusCompany\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use Modules\BusCompany\Models\BusCompanyModel;
use IonAuth\Libraries\IonAuth;
use Hermawan\DataTables\DataTable;
use Psr\Log\LoggerInterface;
use Modules\BusCompany\Models\CustomModel;


class BusCompanies extends BaseController
{
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
	       parent::initController($request, $response, $logger);
	       $this->isLoggedIn();

		$this->busCompanyModel = new BusCompanyModel();
		$this->customModel = new CustomModel();
	}

	
	public function index()
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}
		
		$data = [
			'title' => 'Bus Companies',
			//'records' => $this->busCompanyModel->select('id,  email, address, created_by, is_active')->findAll()

		];
		return view('\Modules\BusCompany\Views\list', $data);
	}

	/*
	* This function is to perform server side datatable
	*/
	public function ajaxDatatables()
	{
		$builder = $this->busCompanyModel->get_datatable_bus_company($this->configAuditSurvey->table_bus_companies);
        return DataTable::of($builder)
        		->add('is_active', function($row){
        			$status = "Inactive";
        			if($row->is_active == '1')
        			{
        				$status = "Active";
        			}
        			
        			return $status;
    			})
        		->add('action', function($row){
        			$action = '<a href="'.base_url('bus-companies/edit/' . base64_encode($row->id)).'"><i class="fas fa-edit"></i></a>';
        			$action .= '<a href="'.base_url('bus-companies/view/' . base64_encode($row->id)).'"><i class="far fa-eye"></i></a>';
        			$action .='<a class="del_bus_company" data-id="'.base64_encode($row->id).'"><i class="fas fa-trash"></i></a>';
        			return $action;
    			})
    			->add('routes', function($row){
        			$routes = '<a href="'.base_url('bus-routes/company/' . base64_encode($row->id)).'">View Routes</a>';
        			return $routes;
    			})
    			->filter(function ($builder, $request) {  

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
            		else
            		{
            			$builder->where($request->listsearchfilter, $request->search_value);
            		}
    			})
               ->addNumbering('no') 
               ->toJson(true);
	}

	/**
	 * add - Add bus company
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function add()
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}


		$data = [
			'title' => 'Bus Companies - Add',
			'state_master' => $this->busCompanyModel->get_all_data($this->configAuditSurvey->table_state_master)
		];
		if ($this->request->getPost()) {
			// validate form input
			$this->validation->setRule('name', 'Name', 'required|is_unique[bus_companies.company_name]');
			$this->validation->setRule('address1', 'Address1', 'required');
			$this->validation->setRule('state', 'state', 'required');
			$this->validation->setRule('city', 'city', 'required');
			$this->validation->setRule('zipcode', 'zipcode', 'required');
			$this->validation->setRule('mobile', 'mobile', 'required');
			$this->validation->setRule('ext', 'ext', 'required');
			$this->validation->setRule('email', 'email', 'required|valid_email');
			$this->validation->setRule('contractor_code', 'contractor code', 'required|is_unique[bus_companies.contractor_code]');


			if ($this->validation->withRequest($this->request)->run()) {
				$additionalData = [
					'company_name' => trim($this->request->getPost('name')),
					'email' 	=> trim($this->request->getPost('email')),
					'address1' 	=> trim($this->request->getPost('address1')),
					'address2' 	=> trim($this->request->getPost('address2')),
					'is_active' => '1',
					'city' 	=> trim($this->request->getPost('city')),
					'state' 	=> $this->request->getPost('state'),
					'zipcode' 	=> trim($this->request->getPost('zipcode')),
					'phone' 	=> trim($this->request->getPost('mobile')),
					'extension' 	=> trim($this->request->getPost('ext')),
					'contractor_code' 	=> trim($this->request->getPost('contractor_code')),
					'created_by'=> $this->ionAuth->user()->row()->id
				];



				if ($this->busCompanyModel->insert($additionalData)) {
					$this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/bus-companies/add');
				} else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
			} else {
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}
		return view('\Modules\BusCompany\Views\add', $data);
	}

	/**
	 * Edit Bus Company - To edit the bus company
	 *
	 * @param int $id to edit record
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function edit($id)
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}

		$id = base64_decode($id);
		$record = $this->busCompanyModel->select('*')->find($id);
		if (!$record) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/bus-companies');
		}
		$data = [
			'title' => 'Bus Companies - Edit',
			'record' => $record,
			'state_master' => $this->busCompanyModel->get_all_data($this->configAuditSurvey->table_state_master)
		];
		if ($this->request->getPost()) {
			$this->validation->setRule('name', 'Name', 'required');
			$this->validation->setRule('address1', 'Address1', 'required');
			$this->validation->setRule('address2', 'address2', 'required');
			$this->validation->setRule('state', 'state', 'required');
			$this->validation->setRule('city', 'city', 'required');
			$this->validation->setRule('zipcode', 'zipcode', 'required');
			$this->validation->setRule('mobile', 'mobile', 'required');
			$this->validation->setRule('ext', 'ext', 'required');
			$this->validation->setRule('email', 'email', 'required|valid_email');

			if(strcmp($record->contractor_code,$this->request->getPost('contractor_code')) != 0) 
			{
				$this->validation->setRule('contractor_code', 'contractor code', 'required|is_unique[bus_companies.contractor_code]');
			}

			if ($this->validation->withRequest($this->request)->run()) {
				$update_data = [
					'company_name' => trim($this->request->getPost('name')),
					'email' 	=> trim($this->request->getPost('email')),
					'address1' 	=> trim($this->request->getPost('address1')),
					'address2' 	=> trim($this->request->getPost('address2')),
					'is_active' 	=> '1',
					'city' 	=> trim($this->request->getPost('city')),
					'state' 	=> $this->request->getPost('state'),
					'zipcode' 	=> trim($this->request->getPost('zipcode')),
					'phone' 	=> trim($this->request->getPost('mobile')),
					'extension' 	=> trim($this->request->getPost('ext')),
					'contractor_code' 	=> trim($this->request->getPost('contractor_code')),
				];
				if ($this->busCompanyModel->update($id, $update_data)) {
					$this->session->setFlashdata('success_message', 'Record Updated');
				} else {
					$this->session->setFlashdata('error_message', 'Update failed');
				}
				return redirect()->to('/bus-companies');
			} else {
				$this->session->setFlashdata('error_message', $this->validation->listErrors('list'));
			}
		}

		return view('\Modules\BusCompany\Views\edit', $data);
	}

	/**
	 * delete - To delete the bus company
	 *
	 * @param int $id to delete record
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function delete($id)
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}

		$bus_company_id = base64_decode($id);
		$record = $this->busCompanyModel->select('*')->find($bus_company_id);
		if ($record) 
		{
			$data = [
	    			'deleted' => '1',
			];
			$this->busCompanyModel->update($bus_company_id, $data);
			return redirect()->back()->with('success_message', 'Deleted Successfully');
		}
		else
		{
			return redirect()->back()->with('error_message', 'Invalid record id');
		}
	}

	/**
	 * view - To view the bus company
	 *
	 * @param int $id to view record
	 *
	 * @return string|\CodeIgniter\HTTP\RedirectResponse
	 */
	public function view($id)
	{
		if (!$this->ionAuth->loggedIn() || !$this->ionAuth->isAdmin()) {
			return redirect()->to('/login');
		}

		$bus_company_id = base64_decode($id);
		$record = $this->busCompanyModel->select('*')->find($bus_company_id);
		if ($record) 
		{
			$data = [
				'title' => 'Bus Companies - View',
				'record' => $record,
				'state_master' => $this->busCompanyModel->get_all_data($this->configAuditSurvey->table_state_master)
			];
			//echo "<pre>"; print_r($record); exit;
			return view('\Modules\BusCompany\Views\view',$data);
		}
		else
		{
			return redirect()->back()->with('error_message', 'Invalid record id');
		}
	}


	public function getcities($state_id)
	{
    		$get_cities = $this->busCompanyModel->getwhere_data($this->configAuditSurvey->table_city_master,'id_state',$state_id);

		echo json_encode($get_cities);

	}

	/**
	 * Function is to check whether bus company is related with bus route module
	 */
	public function checkMapping()
	{
		$return_data = $this->customModel->getwhere_record($this->configAuditSurvey->table_bus_company,array('bus_company_id' => base64_decode($this->request->getPost('id')),'is_deleted' => '0'));

		if(!empty($return_data))
		{
			echo json_encode(array('status' => '1','message' => 'Cannot Delete, Mapped with Bus route module'));
		}
		else
		{
			echo json_encode(array('status' => '0','message' => 'Deleted Successfully'));
		}

	}
}
