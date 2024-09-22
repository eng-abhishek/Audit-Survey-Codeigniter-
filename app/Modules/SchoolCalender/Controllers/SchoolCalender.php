<?php
namespace Modules\SchoolCalender\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\BaseController;
use Psr\Log\LoggerInterface;
use IonAuth\Libraries\IonAuth;
use App\Config\Email;
use Modules\SchoolCalender\Models\SchoolCalenderModel;

class SchoolCalender extends BaseController
{
	public function __construct()
	{
		$this->ionAuth = new IonAuth();
		$this->configIonAuth = config('IonAuth');
		if (!$this->ionAuth->loggedIn()){
			$this->session->setFlashdata('error_message', 'Unauthorized access');
			return redirect()->to('/login');
		}
		$this->SchoolCalenderModel = new SchoolCalenderModel;
	}

	public function index()
	{
	if(in_array(session('user_type'),config('AuditSurvey')->menu_school_calender)) { 
	$data=array(
	           'title'=>'School Calendar',
	           );	
    return view('\Modules\SchoolCalender\Views\add', $data);
	}else{
	return redirect()->to('/login');	
	}	
	}

    public function	getSelectedDate(){
    $calender=$this->SchoolCalenderModel->getDateList();
    foreach ($calender as $key => $row) {
    if($row['type']=='Holiday'){ $color='#f3991245'; }else{ $color='#ffc107';}
    	   $data[]=array(
    	  'id'=>$row['id'], 	
          'title'=>$row['type'],
          'start'=>$row['start_date'],
          'end'=>$row['end_date'], 
          "color" =>$color,
    	 );
    }
    echo json_encode($data);
	}

	public function insert(){
    $this->SchoolCalenderModel->insertEvent();
	}

	public function update(){
    $this->SchoolCalenderModel->updateEvent();
	}

	public function delete(){
    $this->SchoolCalenderModel->removeEvent();
	}
}
