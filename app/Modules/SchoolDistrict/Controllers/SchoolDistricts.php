<?php
namespace Modules\SchoolDistrict\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use Modules\SchoolDistrict\Models\SchoolDistrictModel;
use IonAuth\Libraries\IonAuth;
use Hermawan\DataTables\DataTable;

		class SchoolDistricts extends BaseController
		{
		public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
		{
		parent::initController($request, $response, $logger);
		$this->isLoggedIn();
		$this->schoolDistrictModel = new SchoolDistrictModel();
		}

		public function index()
		{
        if(in_array(session('user_type'),config('AuditSurvey')->menu_districts)) {
	    $data = [
		'title' => 'Districts',
		'district_list'=>$this->schoolDistrictModel->get_datatable('school_districts'),
		];
		return view('\Modules\SchoolDistrict\Views\list', $data);
		}else{
		  return redirect()->to('/login');	
		}
		}

		public function add()
		{
			
		if(in_array(session('user_type'),config('AuditSurvey')->menu_districts)) {
        $data = [
		'title' => 'Districts - Add',
		'getState'=>$this->schoolDistrictModel->getState(),
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
		}else{
	     return redirect()->to('/login');
		}
		}

		public function edit($id)
		{
		if(in_array(session('user_type'),config('AuditSurvey')->menu_districts)) {
        $id = base64_decode($id);
		$record = $this->schoolDistrictModel->select('*')->find($id);
		if (!$record) {
		$this->session->setFlashdata('error_message', 'Unauthorized access');
		return redirect()->to('/districts');
		}
		$data = [
		'title' => 'Districts - Edit',
		'record' => $record,
		'getState'=>$this->schoolDistrictModel->getState(),
		'getAllCity'=>$this->schoolDistrictModel->getAllCity($record->state),
		'edit_id'=>$id,
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
		}else{
        return redirect()->to('/login');
		}	
		}


		public function delete($id)
		{
		if(in_array(session('user_type'),config('AuditSurvey')->menu_districts)) {
        $user_id = base64_decode($id);
	    //echo $user_id;
		//echo"<pre>";
		$destData=$this->schoolDistrictModel->checkDestrictUse($user_id);
		if($destData){
        $this->session->setFlashdata('error_message', 'Sorry this destrict used in user module');
        return redirect()->to('/districts');
		}
		
		$user = $this->schoolDistrictModel->select('id')->find($user_id);		
		if (!$user) {
		return redirect()->to('/districts');
		}

		$this->schoolDistrictModel->deleteRecord($user_id);
		$this->session->setFlashdata('error_message', 'Districts deleted');
		return redirect()->to('/districts');

		}else{
        return redirect()->to('/login');
		}	
		}

		public function listofDistrict(){
		$col_name=$_POST['col_name'];
		$input_filter=$_POST['input_filter'];
		echo $this->schoolDistrictModel->listofDistrictDB($col_name,$input_filter);
		}

		public function getCityData(){
		$id=$this->request->getPost('id');
		$city=$this->schoolDistrictModel->getCity($id);
		$cityOption='';
		$cityOption.="<select name='city' class='form-control' required='' id='getCity'>";
		$cityOption.='<option> select city </option>';
		foreach ($city as $key => $cityValue) {
		$cityOption.="<option value='".$cityValue->id."'> ".$cityValue->city." ";
		$cityOption.="</option>";
		}
		$cityOption.="</select>";
		return $cityOption;
		}

		public function view($id){
		if(in_array(session('user_type'),config('AuditSurvey')->menu_districts)){
				$id = base64_decode($id);
		$record = $this->schoolDistrictModel->select('*')->find($id);	
        $data = [
		'title' => 'Districts - View',
		'record' => $record,
		'getState'=>$this->schoolDistrictModel->getState(),
		'getAllCity'=>$this->schoolDistrictModel->getAllCity($record->state),
		];
        return view('\Modules\SchoolDistrict\Views\view', $data);
		}else{
        return redirect()->to('/login');
		}	
		}

		public function update_status(){
		$id=$this->request->getPost('id');
		$status=$this->request->getPost('status');
		$this->schoolDistrictModel->update($id,array('is_active'=>$status));
		echo "1";
		}

		public function check_destrict_code_exist(){
		if($this->schoolDistrictModel->checkDuplicateCode()>0){
        echo"false";
	    }else{
        echo"true";
	    }
		}

		public function check_destrict_code_exist_on_edit(){
        if($this->schoolDistrictModel->checkDuplicateCodeOnEdit()>0){
        echo"true";
        die; 
        }elseif($this->schoolDistrictModel->checkDuplicateCode()>0){
        echo"false";
        die; 
        }else{
        echo"true";
        die; 
        }
		}
		
		}
