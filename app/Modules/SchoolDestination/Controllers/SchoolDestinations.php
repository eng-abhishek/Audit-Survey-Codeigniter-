<?php
namespace Modules\SchoolDestination\Controllers;
use App\Controllers\BaseController;
use Modules\SchoolDestination\Models\SchoolDestinationModel;
use IonAuth\Libraries\IonAuth;
use Hermawan\DataTables\DataTable;

class SchoolDestinations extends BaseController
{
	public $db;
	public function __construct()
	{
		 $this->db = \Config\Database::connect();
		$this->ionAuth = new IonAuth();
		$this->configIonAuth = config('IonAuth');
		if (!$this->ionAuth->loggedIn()) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/login');
		}
		$this->schoolDestinationModel = new SchoolDestinationModel();
	}

	public function index()
	{
	 if(in_array(session('user_type'),config('AuditSurvey')->menu_school_destination)) { 
		$data = [
			'title' => 'School Destinations',
			'records' => $this->schoolDestinationModel->getAllList(),
			    ];
		return view('\Modules\SchoolDestination\Views\list', $data);
		 }else{
         return redirect()->to('/login');
		 }		
	}

	public function add()
	{
	if(in_array(session('user_type'),config('AuditSurvey')->menu_school_destination)) {
		$data = [
			'title' => 'School Destinations - Add',
			'getState'=>$this->schoolDestinationModel->getState(),
			'allRoute'=>$this->schoolDestinationModel->getAllRoute(),
		        ];
		if ($this->request->getPost()) {
			// validate form input
			$this->validation->setRule('school_name','School Name', 'required');
			$this->validation->setRule('address1', 'Address 1', 'trim|required');
            $this->validation->setRule('address2','Address 2', 'trim|required');
            $this->validation->setRule('state', 'State', 'required');
            $this->validation->setRule('city','City', 'required');
            $this->validation->setRule('zipcode', 'Zip Code', 'required');
			$this->validation->setRule('office_phone','Office Phone number', 'required');
            $this->validation->setRule('office_email','Office email', 'required');
			$this->validation->setRule('office_fax','Office Fax', 'required');
            $this->validation->setRule('school_code','School Code', 'required');

			if ($this->validation->withRequest($this->request)->run()){
				$additionalData = [
					'school_name'=> $this->request->getPost('school_name'),
					'incharge_id'	=> $this->ionAuth->user()->row()->id,
					'address1' => $this->request->getPost('address1'),
                    'address2'=> $this->request->getPost('address2'),
					'state' => $this->request->getPost('state'),
	                'city'=>$this->request->getPost('city'),
                    'zipcode'=> $this->request->getPost('zipcode'),
					'office_phone' => $this->request->getPost('office_phone'),
					'office_email'=>$this->request->getPost('office_email'),
                    'office_fax'=> $this->request->getPost('office_fax'),
					'school_code' => $this->request->getPost('school_code'),
					'active_routes' => $this->request->getPost('active_routes'),
					'website_url' => $this->request->getPost('website_url'),
					'created_by'	=> $this->ionAuth->user()->row()->id,
					'is_active'=>$this->request->getPost('destination_status') ? : 0,
				];
				if ($this->schoolDestinationModel->insert($additionalData)) {
					$this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/school-destination');
				} else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
			} else {
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		    }
		    return view('\Modules\SchoolDestination\Views\add', $data);
		  }else{
         return redirect()->to('/login');
		 }	
	}

	public function edit($id)
	{
	if(in_array(session('user_type'),config('AuditSurvey')->menu_school_destination)) { 
	
	$id = base64_decode($id);
        $record = $this->schoolDestinationModel->select('*')->find($id);
		if (!$record) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/school-destination');
		}
		$data = [
			'title' => 'School Destinations - Edit',
			'record' => $record,
		    'getState'=>$this->schoolDestinationModel->getState(),
		    'getAllCity'=>$this->schoolDestinationModel->getAllCity($record->state),
		    'allRoute'=>$this->schoolDestinationModel->getAllRoute(),
		    'total_route'=>$this->schoolDestinationModel->getAssignedBusRoute($id),
		    'OACIncharge'=>$this->schoolDestinationModel->getOACIncharge($id),
		];
		if ($this->request->getPost()) {

            $this->validation->setRule('school_name','School Name', 'required');
			$this->validation->setRule('address1', 'Address 1', 'trim|required');
            $this->validation->setRule('address2','Address 2', 'trim|required');
            $this->validation->setRule('state', 'State', 'required');
            $this->validation->setRule('city','City', 'required');
            $this->validation->setRule('zipcode', 'Zip Code', 'required');
			$this->validation->setRule('office_phone','Office Phone number', 'required');
            $this->validation->setRule('office_email','Office email', 'required');
			$this->validation->setRule('office_fax','Office Fax', 'required');
            $this->validation->setRule('school_code','School Code', 'required');

			if ($this->validation->withRequest($this->request)->run()) {
				$update_data = [
			    	'school_name'=> $this->request->getPost('school_name'),
					'incharge_id'	=> $this->ionAuth->user()->row()->id,
					'address1' => $this->request->getPost('address1'),
                    'address2'=> $this->request->getPost('address2'),
					'state' => $this->request->getPost('state'),
	                'city'=>$this->request->getPost('city'),
                    'zipcode'=> $this->request->getPost('zipcode'),
					'office_phone' => $this->request->getPost('office_phone'),
					'office_email'=>$this->request->getPost('office_email'),
                    'office_fax'=> $this->request->getPost('office_fax'),
					'school_code' => $this->request->getPost('school_code'),
					'active_routes' => $this->request->getPost('active_routes'),
					'website_url' => $this->request->getPost('website_url'),
					'created_by'	=> $this->ionAuth->user()->row()->id
				];
				if($this->schoolDestinationModel->update($id, $update_data)){
					$this->session->setFlashdata('success_message', 'Record Updated');
				} else {
					$this->session->setFlashdata('error_message', 'Update failed');
				}
				return redirect()->to('/school-destination');
			}else {
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		   }
		 return view('\Modules\SchoolDestination\Views\edit', $data);	 
		 }else{
         return redirect()->to('/login');
		 }	
	}

	public function view($id)
	{
	 if(in_array(session('user_type'),config('AuditSurvey')->menu_school_destination)) { 
		 
			$id = base64_decode($id);
		$record = $this->schoolDestinationModel->select('*')->find($id);
		if (!$record) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/school-destination');
		}
		$data = [
			'title' => 'School Destinations - View',
			'record' => $record,
		];
		return view('\Modules\SchoolDestination\Views\view', $data);	 

		 }else{
         return redirect()->to('/login');
		 }		
	}

	public function update_status(){
    $id=$this->request->getPost('id');
    $status=$this->request->getPost('status');
	$this->schoolDestinationModel->update($id,array('is_active'=>$status));
	echo "1";
	}

	public function delete($id)
	{
	 if(in_array(session('user_type'),config('AuditSurvey')->menu_school_destination)) { 
		$user_id = base64_decode($id);
		$user = $this->schoolDestinationModel->select('id')->find($user_id);		
		if (!$user) {
			return redirect()->to('/school-destination');
		}
		$this->schoolDestinationModel->deleteRecord($user_id);
		$this->session->setFlashdata('error_message', 'Record deleted');
		return redirect()->to('/school-destination'); 
		 }else{
         return redirect()->to('/login');
		 }		
	    
	}

		public function listofDestination(){
		echo $this->schoolDestinationModel->getdestinationList($_POST['col_name'],$_POST['input_filter']);
		 }

		        public function getCityData(){
                $id=$this->request->getPost('id');
				$city=$this->schoolDestinationModel->getCity($id);
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
}
