<?php
namespace Modules\BusRoute\Controllers;
error_reporting(1);
use App\Controllers\BaseController;
use Modules\BusRoute\Models\BusRouteModel;
use Modules\User\Models\UserModel;
use Modules\RegionalAuthority\Models\RegionalAuthorityModel;
use Modules\SchoolDistrict\Models\SchoolDistrictModel;
use Modules\SchoolDestination\Models\SchoolDestinationModel;
use Modules\BusRoute\Models\BusRouteRtcOutsourcedModel;
use Modules\BusRoute\Models\BusRouteSchoolDestinationModel;
use Modules\Student\Models\StudentModel;
use Modules\Survey\Models\SurveyModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Modules\BusCompany\Models\BusCompanyModel;
use IonAuth\Libraries\IonAuth;
use Hermawan\DataTables\DataTable;
class BusRoutes extends BaseController
{
	public function __construct()
	{
		$this->ionAuth = new IonAuth();
		$this->configIonAuth = config('IonAuth');
		if (!$this->ionAuth->loggedIn()) {
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/login');
		}
		$this->busRouteModel = new BusRouteModel();
		$this->userModel = new UserModel();
		$this->regionalAuthorityModel = new RegionalAuthorityModel();
		$this->schoolDistrictModel = new SchoolDistrictModel();
		$this->busCompanyModel = new BusCompanyModel();
		$this->schoolDestinationModel = new SchoolDestinationModel();
		$this->studentModel = new StudentModel();
        $this->surveyModel= new SurveyModel();
        $this->db = \Config\Database::connect();
	    }

		public function index($bus_company = '')
		{
		 if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 
		 $listofrt=$this->busRouteModel->get_busRoute($bus_company);
		$data = [
		'title' => 'Bus Routes',
		'listOfBusRoute'=>array_reverse($listofrt['listOfBusRoute']),
		];
		return view('\Modules\BusRoute\Views\list', $data);
		 }else{
         return redirect()->to('/login');
		 }	
		 }

        public function getexcel(){
        if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 
		 
        $tmpfileName = 'template.csv';  
		$tmpspreadsheet = new Spreadsheet();

		$tmpsheet = $tmpspreadsheet->getActiveSheet()->setTitle('First tab');

		$tmpsheet->setCellValue('A1', 'Student Id');
		$tmpsheet->setCellValue('B1', 'School Destination Id');
		$tmpsheet->setCellValue('C1', 'Student First Name');
		$tmpsheet->setCellValue('D1', 'Student Last Name');

		$tmpwriter = new Xlsx($tmpspreadsheet);

		$tmpspreadsheet->createSheet();
		// Zero based, so set the second tab as active sheet

		$tmpspreadsheet->setActiveSheetIndex(1);
		$sectmpsheet=$tmpspreadsheet->getActiveSheet()->setTitle('Second tab');


        $sectmpsheet->setCellValue('A1','ID');
        $sectmpsheet->setCellValue('B1','Name');
        $sectmpsheet->setCellValue('C1','Class');

        $tmpwriter->save($tmpfileName);
	    header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . basename($tmpfileName) . '"');

		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($tmpfileName));
		flush(); // Flush system output buffer
		readfile($tmpfileName);
		exit;

		 }else{
         return redirect()->to('/login');
		 }		
         }

	    public function add()
    	{
        if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 

         $data = [
			'title' => 'Bus Routes - Add',
			 'users'	=> $this->userModel->select('id,username')->where('active', 1)->findAll(),
			 'schoolDistricts' => $this->schoolDistrictModel->select('id,district_name')->where('is_active', 1)->findAll(),
			 'busCompanies' => $this->busCompanyModel->select('id,company_name')->where('is_active', 1)->findAll(),
			 'schoolDestination' =>$this->schoolDestinationModel->select('id,school_name')->where('is_active','1')->findAll(),
			 'surveyList'=>$this->surveyModel->find(),
			    ];
     
		if ($this->request->getPost()){

			// validate form input
			$this->validation->setRule('incharge_id','Route Managed By', 'required');
			$this->validation->setRule('ltc_route_name','LTC Route Name', 'required');
			$this->validation->setRule('from_date', 'Start Date', 'required');
			$this->validation->setRule('to_date', 'End Date', 'required');

			$this->validation->setRule('shift', 'Shift', 'required');

			$this->validation->setRule('vehicle_type', 'Vehicle Type', 'required');
			
			$this->validation->setRule('bus_company_id', 'Bus Company', 'required');
			$this->validation->setRule('school_destination_id', 'School Destination', 'required');

			if ($this->validation->withRequest($this->request)->run()) {
				$additionalData = [
					'coordinator_id' => $this->request->getPost('incharge_id'),
					'route_name' 	=> $this->request->getPost('ltc_route_name'),
					'start_date' 	=> $this->request->getPost('from_date'),
					'end_date' 	=> $this->request->getPost('to_date'),
					'shift' 	=> implode(',',$this->request->getPost('shift')),
					'vehicle_type' 	=> $this->request->getPost('vehicle_type'),
				    'bus_company_id'=> $this->request->getPost('bus_company_id'),
				    'managed_by' => $this->ionAuth->user()->row()->id,
				    'is_active'=>$this->request->getPost('busRoute_status')? : 0,
				                  ];
                  if(!empty($this->request->getPost('is_this_route_outsourced'))){
                  $additionalData['oac_route_name']=$this->request->getPost('rtc_route_name');
                  }
                
			    	if($this->busRouteModel->insert($additionalData)){
					$bus_route_lastId=$this->busRouteModel->getInsertID();
                    if(!empty($this->request->getPost('survey_id'))){
                  //$additionalData['assigned_to_survey']=$this->request->getPost('survey_id');
                  	$countServey=$this->request->getPost('survey_id');
                    $this->busRouteModel->insertSurvey($bus_route_lastId,$countServey);
                    }
                   $numofDest=$this->request->getPost('school_destination_id');
                   $this->busRouteModel->insertDestination($numofDest,$bus_route_lastId);
			        /*--- upload excel ----*/

					if($file = $this->request->getFile('uploadFile')){
					if ($file->isValid() && ! $file->hasMoved()){

					// // Get random file name
					// $newName = $file->getRandomName();
					// // Store file in public/csvfile/ folder
					// $file->move('csvfile', $newName);
					// // Reading file
					// $file = fopen("csvfile/".$newName,"r");

					// $i = 0;
					// $numberOfFields = 4; // Total number of fields
					// $importData_arr = array();
					// // Initialize $importData_arr Array
					// while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE){
					// $num = count($filedata);
					// // Skip first row & check number of fields
					// if($i > 0 && $num == $numberOfFields){
					// // Key names are the insert table field names - name, email, city, and status
					// $importData_arr[$i]['vid_id'] = $filedata[0];
					// $importData_arr[$i]['vid_dest_id'] = $filedata[1];
					// $importData_arr[$i]['student_f_name'] = $filedata[2];
					// $importData_arr[$i]['student_l_name'] = $filedata[3];
					// }
					// $i++;
					// }
					// fclose($file);
					
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					$spreadsheet = $reader->load($_FILES['uploadFile']['tmp_name']);
					$sheetData = $spreadsheet->getActiveSheet('Template of import student')->toArray();
					foreach ($sheetData as $key => $val) {
					if($key==0){
					}else{
					$importData_arr[$key]['vid_id'] = $val[0];
					$importData_arr[$key]['vid_dest_id'] = $val[1];
					$importData_arr[$key]['student_f_name'] = $val[2];
					$importData_arr[$key]['student_l_name'] = $val[3];
					}
					}
					$chkSheet=$this->busRouteModel->insertVirathy($bus_route_lastId,$importData_arr);
                   
				    if($chkSheet=='10'){
				      $this->session->setFlashdata('success_message', 'Record Added');	
                      session()->setFlashdata('error_message','some record is invalide, please import valide student id or name.');
					  return redirect()->to('/bus-routes');

					}elseif($chkSheet=='20'){
					  $this->session->setFlashdata('success_message', 'Record Added');	
                       session()->setFlashdata('error_message','some record is invalide, please import valide destination id.');
					  return redirect()->to('/bus-routes');
				
					}else{ }

					}else{
					// Set Session
					session()->setFlashdata('error_message', 'File not imported.');
					}
					}
                   /*---end upload excel ----*/
				   $this->session->setFlashdata('success_message', 'Record Added');
					return redirect()->to('/bus-routes');
				   } else {
					$this->session->setFlashdata('error_message', 'Add failed');
				}
	     		} else {
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		   }
		 }else{
         return redirect()->to('/login');
		 }

		return view('\Modules\BusRoute\Views\add', $data);
	}

	    public function edit($id)
	    {
        if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 
		 
         $id = base64_decode($id);
		$record = $this->busRouteModel->geteditData($id);
		
		$userData=$this->userModel->select('*')->find($record[0]->coordinator_id);
      
        $getSelectedDestination=$this->busRouteModel->getSelectedDestination($id);

		$arrDestination = array_map (function($value){
		return $value['school_destination_id'];
		} , $getSelectedDestination);
 
        $getSurveyRoute=$this->busRouteModel->getSurveyRoute($id);
       
        $arrSurveyRoute = array_map (function($value){
		return $value['surveys_id'];
		} , $getSurveyRoute);

		if (!$record[0]){
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/bus-routes');
		}
		$data = [
			 'title' => 'Bus Routes - Edit',
			 'record' => $record[0],
			 'users'	=> $this->userModel->select('id,username')->where('active', 1)->findAll(),
			 'busCompanies' => $this->busCompanyModel->select('id,company_name')->where('is_active', 1)->findAll(),
			 'schoolDestination' =>$this->schoolDestinationModel->select('id,school_name')->where('is_active','1')->findAll(),
			 'getSelectedDestination'=>$arrDestination,
			 'surveyList'=>$this->surveyModel->find(),
			 'userDetails'=>$userData,
			 'arrRouteSurveyId'=>$arrSurveyRoute,

		      ];
		if ($this->request->getPost()) {
	        $this->validation->setRule('incharge_id','Route Managed By', 'required');
			$this->validation->setRule('ltc_route_name','LTC Route Name', 'required');
			$this->validation->setRule('from_date', 'Start Date', 'required');
			$this->validation->setRule('to_date', 'End Date', 'required');
			$this->validation->setRule('shift', 'Shift', 'required');
			$this->validation->setRule('vehicle_type', 'Vehicle Type', 'required');
			$this->validation->setRule('bus_company_id', 'Bus Company', 'required');
			$this->validation->setRule('school_destination_id', 'School Destination', 'required');
			if ($this->validation->withRequest($this->request)->run()) {
				$update_data = [
	                'coordinator_id' => $this->request->getPost('incharge_id'),
					'route_name' 	=> $this->request->getPost('ltc_route_name'),
					'start_date' 	=> $this->request->getPost('from_date'),
					'end_date' 	=> $this->request->getPost('to_date'),
					'shift' 	=> implode(',',$this->request->getPost('shift')),
					'vehicle_type' 	=> $this->request->getPost('vehicle_type'),
					'is_active' 	=> $this->request->getPost('is_active'),
				    'bus_company_id'=> $this->request->getPost('bus_company_id'),
				    'managed_by' => $this->ionAuth->user()->row()->id,
				   ];
                 if(!empty($this->request->getPost('is_this_route_outsourced'))){
                  $update_data['oac_route_name']=$this->request->getPost('rtc_route_name');
                  }
           
                  if(!empty($this->request->getPost('survey_id'))){
                  	$countServey=$this->request->getPost('survey_id');
                    $this->busRouteModel->insertSurvey($id,$countServey,'edit');
                    }
                   $numofDest=$this->request->getPost('school_destination_id');
                   $this->busRouteModel->insertDestination($numofDest,$id,'edit');

				    if($this->busRouteModel->update($id, $update_data)){
                   /*--- upload excel ----*/
                    if($file = $this->request->getFile('uploadFile')){
                  
					if ($file->isValid() && ! $file->hasMoved()){

                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					$spreadsheet = $reader->load($_FILES['uploadFile']['tmp_name']);
					$sheetData = $spreadsheet->getActiveSheet('Template of import student')->toArray();
					foreach ($sheetData as $key => $val) {
					if($key==0){
					}else{
					$importData_arr[$key]['vid_id'] = $val[0];
					$importData_arr[$key]['vid_dest_id'] = $val[1];
					$importData_arr[$key]['student_f_name'] = $val[2];
					$importData_arr[$key]['student_l_name'] = $val[3];
					}
					}
					$chkSheet=$this->busRouteModel->insertVirathy($id,$importData_arr,'edit');
                   
				    if($chkSheet=='10'){
				      $this->session->setFlashdata('success_message', 'Record Added');	
                      session()->setFlashdata('error_message','some record is invalid, please import valide student id or name.');
					  return redirect()->to('/bus-routes');

					}elseif($chkSheet=='20'){
					  $this->session->setFlashdata('success_message', 'Record Added');	
                       session()->setFlashdata('error_message','some record is invalid, please import valid destination id.');
					  return redirect()->to('/bus-routes');
				    }else{ }

					}else{
					// Set Session
					session()->setFlashdata('message', 'File not imported.');
					session()->setFlashdata('alert-class', 'alert-danger');
					}
					}
                   /*--- end upload excel ----*/
					$this->session->setFlashdata('success_message', 'Record Updated');
				    }else{
					$this->session->setFlashdata('error_message', 'Update failed');
				    }
				return redirect()->to('/bus-routes');
			   }else{
				$this->session->setFlashdata('error_message', 'Error on data validation');
			}
		}


		 }else{
         return redirect()->to('/login');
		 }
		return view('\Modules\BusRoute\Views\edit', $data);
	}

      public function exportStudentData(){
      if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 
		
      $users=$this->busRouteModel->getexcelImportStudentDestination(); 
      $fileName = 'student_list.csv';  
      $spreadsheet = new Spreadsheet();

      $sheet = $spreadsheet->getActiveSheet()->setTitle('List of Student');
      $sheet->setCellValue('A1', 'Student Id');
      $sheet->setCellValue('B1', 'School Destination Id');
      $sheet->setCellValue('C1', 'Student First Name');
      $sheet->setCellValue('D1', 'Student Last Name');
      $rows = 2; 
      foreach ($users as $val){
          $sheet->setCellValue('A' . $rows, $val->student_id);
          $sheet->setCellValue('B' . $rows, $val->school_destination_id);
          $sheet->setCellValue('C' . $rows, $val->first_name);
          $sheet->setCellValue('D' . $rows, $val->last_name);
          $rows++;
                             }
        $writer = new Xlsx($spreadsheet);

        $spreadsheet->createSheet();
		$spreadsheet->setActiveSheetIndex(1);
		$sectmpsheet=$spreadsheet->getActiveSheet()->setTitle('Template of import student');

	      $sectmpsheet->setCellValue('A1', 'Student Id');
	      $sectmpsheet->setCellValue('B1', 'School Destination Id');
	      $sectmpsheet->setCellValue('C1', 'Student First Name');
	      $sectmpsheet->setCellValue('D1', 'Student Last Name');

	    $filepath=$fileName;
        $writer->save($filepath);
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filepath));
		flush(); // Flush system output buffer
		readfile($filepath);
        exit;

		 }else{
         return redirect()->to('/login');
		 }
        }

	  public function exportTemplate(){
      if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 	
      $tmpfileName = 'template.csv';  
      $tmpspreadsheet = new Spreadsheet();
 
      $tmpsheet = $tmpspreadsheet->getActiveSheet();
    
      $tmpsheet->setCellValue('A1', 'Student Id');
      $tmpsheet->setCellValue('B1', 'School Destination Id');
      $tmpsheet->setCellValue('C1', 'Student First Name');
      $tmpsheet->setCellValue('D1', 'Student Last Name');
      
      $tmpwriter = new Xlsx($tmpspreadsheet);
      $tmpwriter->save($tmpfileName);
	    header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . basename($tmpfileName) . '"');

		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($tmpfileName));
		flush(); // Flush system output buffer
		readfile($tmpfileName);
		exit;
		 }else{
         return redirect()->to('/login');
		 }
		}

// File upload and Insert records
public function importFile(){

 if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 
		 
		// Validation

if($file = $this->request->getFile('uploadFile')){
if ($file->isValid() && ! $file->hasMoved()){
// Get random file name
$newName = $file->getRandomName();

// Store file in public/csvfile/ folder
$file->move('csvfile', $newName);
// Reading file
$file = fopen("csvfile/".$newName,"r");

$i = 0;
$numberOfFields = 2; // Total number of fields
$importData_arr = array();
// Initialize $importData_arr Array
while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE){
$num = count($filedata);
// Skip first row & check number of fields
if($i > 0 && $num == $numberOfFields){
// Key names are the insert table field names - name, email, city, and status
$importData_arr[$i]['vid_id'] = $filedata[0];
$importData_arr[$i]['vid_name'] = $filedata[1];
}
$i++;
}

fclose($file);
$this->busRouteModel->insertVirathy($importData_arr);
// Set Session
session()->setFlashdata('message', $count.' Record inserted successfully!');
session()->setFlashdata('alert-class', 'alert-success');
}else{
// Set Session
session()->setFlashdata('message', 'File not imported.');
session()->setFlashdata('alert-class', 'alert-danger');
}
}else{
// Set Session
session()->setFlashdata('message', 'File not imported.');
session()->setFlashdata('alert-class', 'alert-danger');
}
return redirect()->route('/'); 


		 }else{
         return redirect()->to('/login');
		 }
}

	public function getUserForBusRoute(){
    $udata=$this->userModel->find($_POST['id']);
    $output='';
    $output.='<div class="row">
                        <div class="col-sm-3">Name :</div>
                        <div class="col-sm-3">'.$udata->first_name.'</div>
                        <div class="col-sm-3">Status :</div>
                        <div class="col-sm-3">Utter Pradesh</div>
                        </div> 
                        <div class="row">
                        <div class="col-sm-3">Email Id:</div>
                        <div class="col-sm-3">'.$udata->email.'</div>
                        <div class="col-sm-3">Contact No:</div>
                        <div class="col-sm-3">'.$udata->phone.'</div>
                        </div>
                        <div class="row">
                        <div class="col-sm-3">Address :</div>
                        <div class="col-sm-3">'.$udata->address.'</div>
                        <div class="col-sm-3">City :</div>
                        <div class="col-sm-3">'.$udata->city.'</div>
                        </div>';
                        echo $output;                
	}

  	 public function getListData(){
     $builder=$this->busRouteModel->get_busRoute();
     }

    public function viewStudent($id){
    if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) {
    $id = base64_decode($id);
    $data['listOfStudentBusRoute']=$this->busRouteModel->get_listofBusStudent($id);
    $data['listOfAllStudent']=$this->busRouteModel->get_listofAllStudent();
    return view('\Modules\BusRoute\Views\student_assign_bus_route', $data);

		 }else{
         return redirect()->to('/login');
		 }
    }

    public function assiginBusRouteToStudent(){
        $arr=[
         'bus_route_id'=>base64_decode($this->request->getPost('busRuteID')),
         'school_destination_id'=>$this->request->getPost('destID'),
         'student_id'=>$this->request->getPost('sid'),
         ];
         $routeID=base64_decode($this->request->getPost('busRuteID'));
        if($this->busRouteModel->insertAssignRoute($arr,$this->request->getPost('sid'),$routeID)==101){
        session()->setFlashdata('error_message','Bus route already assign to this student.');
        }else{
        session()->setFlashdata('success_message','Record Added');	
        }
    }

   public function removeAssiginBusRouteToStudent(){
   $this->busRouteModel->removeAssignRoute($this->request->getPost('id'),$this->request->getPost('rid'));
    session()->setFlashdata('success_message','Record Removed');
    }

   public function listofRoute(){
   extract($_POST);
   $data=$this->busRouteModel->listofRoute($col_name,$input_filter);
   $output='';
   foreach ($data as $listRecord){
   foreach ($listRecord as $key=>$value){
   $index=$key+1;	
   $viewstudent=base_url('bus-routes/view-student/'.base64_encode($value['route_id']));
   $editurl=base_url('bus-routes/edit/' . base64_encode($value['route_id'])); 
   $viewmoreurl=base_url('bus-routes/view/' . base64_encode($value['route_id']));
   $delurl=base_url('bus-routes/delete/' . base64_encode($value['route_id']));
  if($value['is_active'] == '1'){
                              $val="checked";
                                 $valtext="Active";
                              }else{
                              $val="";
                               $valtext="Inactive";
                              }
                            $output.='<tr>
                            <td>'.$index.'</td>
                            <td>'.$value['route_name'].'</td>
                            <td>'.$value['start_date'].'</td>
                            <td>'.$value['end_date'].'</td>
                            <td>'.$value['shift'].'</td>
                            <td>'.$value['vehicle_type'].'</td>
                            <td>'.$value['sch_name'].'</td>
                            <td>'.$value['company_name'].'</td>
                            <td><a style="color:black" href="'.$viewstudent.'">view student</a></td>
                            <td><p id="textStatus'.$value['route_id'].'">'.$valtext.'</p></td>
                            <td>'.$value['total_survey'].'</td>
                            <td>'.$value['alert_survey'].'</td>
                            <td>
                            <div class="custom-control custom-switch">
							<input type="checkbox" class="busRouteStatus custom-control-input listaction" name="status'.$value['route_id'].'" id="status'.$value['route_id'].'" '.$val.' data-rid="'.$value['route_id'].'">
							<label class="custom-control-label" for="status'.$value['route_id'].'"></label>
							<input type="text" name="rid'.$value['route_id'].'" id="rid'.$value['route_id'].'" hidden value="'.$value['is_active'].'">
                            <a href="'.$editurl.'"><i class="fas fa-edit"></i></a>
                            <a href="'.$viewmoreurl.'"><i class="far fa-eye"></i></a>
                            <a href="'.$delurl.'"><i class="fas fa-trash"></i></a>
                            </td></tr></div>';
                            }  }
                            return $output;
                            }

                    public function update_status(){
                    extract($_POST);
                    $this->busRouteModel->update_status($status,$id);
                    echo "1";
                    }

					public function details($id){
					if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 

                    $id = base64_decode($id);
					$record = $this->busRouteModel->geteditData($id);

					$userData=$this->userModel->select('*')->find($record[0]->coordinator_id);

					$getSelectedDestination=$this->busRouteModel->getSelectedDestination($id);

					$arrDestination = array_map (function($value){
					return $value['school_destination_id'];
					} , $getSelectedDestination);

					$getSurveyRoute=$this->busRouteModel->getSurveyRoute($id);

					$arrSurveyRoute = array_map (function($value){
					return $value['surveys_id'];
					} , $getSurveyRoute);

					if (!$record[0]){
					$this->session->setFlashdata('error_message', 'Unauthorized access');
					return redirect()->to('/bus-routes');
					}
					$data = [
					'title' => 'Bus Routes - View',
					'record' => $record[0],
					'users'	=> $this->userModel->select('id,username')->where('active', 1)->findAll(),
					'busCompanies' => $this->busCompanyModel->select('id,company_name')->where('is_active', 1)->findAll(),
					'schoolDestination' =>$this->schoolDestinationModel->select('id,school_name')->where('is_active','1')->findAll(),
					'getSelectedDestination'=>$arrDestination,
					'surveyList'=>$this->surveyModel->find(),
					'userDetails'=>$userData,
					'arrRouteSurveyId'=>$arrSurveyRoute,

					];
					return view('\Modules\BusRoute\Views\details', $data);
					}else{
					return redirect()->to('/login');
					}
					}

					public function delete($id)
					{
					if(in_array(session('user_type'),config('AuditSurvey')->menu_bus_routes)) { 
                    $user_id = base64_decode($id);
				    $this->busRouteModel->deleteRec($user_id);
					$this->session->setFlashdata('error_message', 'Bus Route deleted');
					return redirect()->to('/bus-routes');
					}else{
					return redirect()->to('/login');
					}
					}
}