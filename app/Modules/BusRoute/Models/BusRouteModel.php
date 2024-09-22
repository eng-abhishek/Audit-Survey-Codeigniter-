<?php
namespace Modules\BusRoute\Models;
use CodeIgniter\Model;
class BusRouteModel extends Model
{
	
	protected $DBGroup              = 'default';
	protected $table                = 'bus_company_routes';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['coordinator_id','route_name', 'start_date', 'end_date', 'shift', 'vehicle_type','school_district_id','bus_company_id', 'school_destination_id', 'managed_by','assigned_to_survey','oac_route_name'];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';
	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

   public function __construct(){
   	$this->db = \Config\Database::connect();
   }

   public function insertDestination($numofDest,$bus_route_lastId,$type=''){
   if(!empty($type)){
   $this->db->table('bus_route_school_destination')->where('route_id',$bus_route_lastId)->delete();
       }
   for($i=0;$i<count($numofDest);$i++){
    $this->db->table('bus_route_school_destination')->insert(['route_id'=>$bus_route_lastId,'school_destination_id'=>$numofDest[$i],'created_at'=>date('Y-m-d h:i:s')]);
   }
   }

		public function insertSurvey($bus_route_lastId,$countServey,$type=''){
        if(!empty($type)){
        $this->db->table('surveys_bus_routes')->where('surveys_id',$bus_route_lastId)->delete();
        }
        for($i=0;$i<count($countServey);$i++){
         $arr=[
          'surveys_id'=>$countServey[$i],
          'bus_route_id'=>$bus_route_lastId,
             ];
         $this->db->table('surveys_bus_routes')->insert($arr);
        }
		}
    
		public function getSurveyRoute($id){
        return $this->db->table('surveys_bus_routes')->select('surveys_id')->where('bus_route_id',$id)->get()->getResultArray();
		}

	   public function insertOutSourceRoute($bus_route_lastId,$userId,$rtc_route_name,$qac_route_name){
		   $arr=[
          'route_id'=>$bus_route_lastId,
          'user_id'=>$userId,
          'route_name'=>$rtc_route_name,
          'oac_route_name'=>$qac_route_name,
          'created_at'=>date('Y-m-d h:i:s'),
		     ];
        $this->db->table('bus_route_rtc_outsourced')->insert($arr); 		
	    }

		public function insertVirathy($bus_route_lastId,$importData_arr,$type=''){
      // if(!empty($type)){
      // $this->db->table('student_bus_route')->where('bus_route_id',$bus_route_lastId)->delete();
      // }
      // echo"<pre>";
      // print_r($importData_arr);
      // die;
		  foreach($importData_arr as $key => $value){
		  $arr=[
		     'student_id'=>$value['vid_id'],
		     'school_destination_id'=>$value['vid_dest_id'],
		     'bus_route_id'=>$bus_route_lastId,
		     ];
    
	   	$tblDB=$this->db->table('students')->where(['id'=>$value['vid_id'],'first_name'=>$value['student_f_name'],'last_name'=>$value['student_l_name']])->get()->getResult();
        if($tblDB){
        $tblDBChkDes=$this->db->table('school_destinations')->where('id',$value['vid_dest_id'])->get()->getResult();
        if($tblDBChkDes){

        $chkDublicateEntry=$this->db->query('select count(id) as id from student_bus_route where student_id ="'.$value['vid_id'].'" && bus_route_id ="'.$bus_route_lastId.'"')->getResult();
        if($chkDublicateEntry[0]->id>0){

        }else{
        $this->db->table('student_bus_route')->insert($arr);
        // $this->db->table('students_school_destination')->where(['student_id'=>$value['vid_id']])->update(['status'=>'1']);
        }
       
        }else{

        return 20;
         }
         }else{

        return 10;
         }
		}
		}

		public function getexcelImportStudentDestination(){
        return $this->db->table('students as a')->select('a.id as student_id,a.first_name,a.last_name,b.school_destination_id')->join('students_school_destination as b','b.student_id=a.id')->where('b.status','0')->get()->getResult();
		}

		public function delete_studentBusRoute($id){
        $this->db->table('student_bus_route')->where('bus_route_id',$id)->delete();
		}

		public function geteditData($id){
        $result=$this->db->table('bus_company_routes')->select('*')->where('id',$id)->get()->getResult();
		return $result;
		}

    	public function getSelectedDestination($id){
        return $this->db->table('bus_route_school_destination')->select('school_destination_id')->where('route_id',$id)->get()->getResultArray();   
	    }

		public function get_listofBusStudent($id){
        return $this->db->table('bus_company_routes a')->select('a.id as route_id,c.first_name,c.last_name,d.school_name,c.id as student_id,c.flg_bus_nurse,c.flg_bus_wheelchair,c.flg_bus_specialreqs,c.flg_bus_aide,c.flg_car_seat_required,c.flg_harness_required,c.flg_bus_specialreqs_desc,c.flg_type_of_chair,c.flg_carharness_type_size,c.special_transportations')->join('student_bus_route b','b.bus_route_id = a.id')->join('students c','c.id = b.student_id')->join('school_destinations d','d.id = b.school_destination_id')->where('b.bus_route_id',$id)->get()->getResult();
		}

		public function get_listofAllStudent(){
        return $this->db->table('students a')->select('a.id as student_id,a.first_name,a.last_name,a.flg_bus_nurse,a.flg_bus_wheelchair,a.flg_bus_specialreqs,a.flg_bus_aide,a.flg_car_seat_required,a.flg_harness_required,a.flg_bus_specialreqs_desc,a.flg_type_of_chair,a.flg_carharness_type_size,c.school_name,c.id as destination_id,d.district_name,a.special_transportations')->join('students_school_destination b','b.student_id=a.id')->join('school_destinations c','c.id=b.school_destination_id')->join('school_districts d','d.id=a.sending_district_id')->where('b.status','0')->get()->getResult();
		}

		public function insertAssignRoute($arr,$sid,$routeId){
	    $chekstudent=$this->db->table('student_bus_route')->where(['student_id'=>$sid,'bus_route_id'=>$routeId])->get()->getResult();
	    if(!empty($chekstudent[0]->id)){
        return 101;
	    }else{
        $this->db->table('student_bus_route')->insert($arr);
        // $this->db->table('students_school_destination')->where('student_id',$sid)->update(['status'=>'1']);
        return 202;
	    }	
		}

		public function removeAssignRoute($id,$routeId){
        $this->db->table('student_bus_route')->where(['student_id'=>$id,'bus_route_id'=>$routeId])->delete();
        // $this->db->table('students_school_destination')->where('student_id',$id)->update(['status'=>'0']);
		}

    public function get_busRoute($bus_company='')
       {
              $bus_company_where = '';
              if($bus_company != '')
              {
                     $bus_company_where = " and a.bus_company_id='".base64_decode($bus_company)."'";
              }
   	    $query = $this->db->query('select a.route_name,a.start_date,a.id as route_id,a.end_date,a.shift,a.vehicle_type,a.is_active,d.company_name from bus_company_routes a left join bus_companies d ON d.id = a.bus_company_id where a.is_deleted=0'.$bus_company_where)->getResultArray();

       
         foreach ($query as $key1 => $value1){
         $arrSchoolDest=[];
         $rid=$value1['route_id'];
         $destId=$this->db->table('bus_route_school_destination e')->select('e.route_id,f.school_name')->join('school_destinations f','f.id=e.school_destination_id')->where('e.route_id',$rid)->get()->getResultArray();
         foreach ($destId as $key2 => $value2) {
         $arrSchoolDest[]=$value2['school_name'];
         }
         $value1['sch_name']=implode(',',$arrSchoolDest);

         $total_survey=$this->db->query('select count(`surveys_id`) as total_survey FROM `surveys_bus_routes` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['total_survey']=$total_survey[0]['total_survey'];

         $total_survey=$this->db->query('select count(`id`) as alert_survey FROM `survey_responses` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['alert_survey']=$total_survey[0]['alert_survey'];
         $data['listOfBusRoute'][]=$value1;
                }
         return $data;
       }

       public function listofRoute($col_name,$input_filter){
		   
	   if($col_name=='route_name' || $col_name=='vehicle_type' || $col_name=='start_date' || $col_name=='end_date' || $col_name=='shift' || $col_name=='is_active'){

		 $query = $this->db->query('select a.route_name,a.start_date,a.id as route_id,a.end_date,a.shift,a.vehicle_type,a.is_active,d.company_name from bus_company_routes a left join bus_companies d ON d.id = a.bus_company_id where a.'.$col_name.' Like "%'.$input_filter.'%" && a.is_deleted=0')->getResultArray();

         foreach ($query as $key1 => $value1){
         $arrSchoolDest=[];
         $rid=$value1['route_id'];
         if($col_name==''){ }
         $destId=$this->db->table('bus_route_school_destination e')->select('e.route_id,f.school_name')->join('school_destinations f','f.id=e.school_destination_id')->where('e.route_id',$rid)->get()->getResultArray();

         foreach ($destId as $key2 => $value2) {
         $arrSchoolDest[]=$value2['school_name'];
         }
         $value1['sch_name']=implode(',',$arrSchoolDest);

         $total_survey=$this->db->query('select count(`surveys_id`) as total_survey FROM `surveys_bus_routes` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['total_survey']=$total_survey[0]['total_survey'];

         $total_survey=$this->db->query('select count(`id`) as alert_survey FROM `survey_responses` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['alert_survey']=$total_survey[0]['alert_survey'];
         $data['listOfBusRoute'][]=$value1;
                }
         
         return $data;
		 }elseif($col_name=='company_name'){
         $query = $this->db->query('select a.route_name,a.start_date,a.id as route_id,a.end_date,a.shift,a.vehicle_type,a.is_active,d.company_name from bus_company_routes a left join bus_companies d ON d.id = a.bus_company_id where d.'.$col_name.' Like "%'.$input_filter.'%" && a.is_deleted=0')->getResultArray();

        foreach ($query as $key1 => $value1){
         $arrSchoolDest=[];
         $rid=$value1['route_id'];

         $destId=$this->db->table('bus_route_school_destination e')->select('e.route_id,f.school_name')->join('school_destinations f','f.id=e.school_destination_id')->where('e.route_id',$rid)->get()->getResultArray();

         foreach ($destId as $key2 => $value2) {
         $arrSchoolDest[]=$value2['school_name'];
         }
         $value1['sch_name']=implode(',',$arrSchoolDest);

         $total_survey=$this->db->query('select count(`surveys_id`) as total_survey FROM `surveys_bus_routes` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['total_survey']=$total_survey[0]['total_survey'];

         $total_survey=$this->db->query('select count(`id`) as alert_survey FROM `survey_responses` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['alert_survey']=$total_survey[0]['alert_survey'];
         $data['listOfBusRoute'][]=$value1;
                }
          return $data;
		     }else{

         $query = $this->db->query('select a.route_name,a.start_date,a.id as route_id,a.end_date,a.shift,a.vehicle_type,a.is_active,d.company_name from bus_company_routes a left join bus_companies d ON d.id = a.bus_company_id && a.is_deleted=0')->getResultArray();

         foreach ($query as $key1 => $value1){
         $arrSchoolDest=[];
         $rid=$value1['route_id'];
         if($col_name=='school_destination'){

         $destId=$this->db->table('bus_route_school_destination e')->select('e.route_id,f.school_name')->join('school_destinations f','f.id=e.school_destination_id')->like('f.school_name',$input_filter)->where('e.route_id',$rid)->get()->getResultArray();
        
         foreach ($destId as $key2 => $value2) {
         $arrSchoolDest[]=$value2['school_name'];
         }
         $value1['sch_name']=implode(',',$arrSchoolDest);

         $total_survey=$this->db->query('select count(`surveys_id`) as total_survey FROM `surveys_bus_routes` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['total_survey']=$total_survey[0]['total_survey'];

         $total_survey=$this->db->query('select count(`id`) as alert_survey FROM `survey_responses` where `bus_route_id`="'.$rid.'" ')->getResultArray();
         $value1['alert_survey']=$total_survey[0]['alert_survey'];
         $data['listOfBusRoute'][]=$value1;

          }else{

          }
          }
         return $data;
		 }
       }

	    public function update_status($status,$id){
        $this->db->table('bus_company_routes')->where('id',$id)->update(['is_active'=>$status]);
        	}

       public function getBusRoute($id){
       return $this->db->table('bus_company_routes')->select('*')->where('id',$id)->get()->getRowArray();  
       }

      public function updateRecord($id,$data){
      $this->db->table('bus_company_routes')->where('id',$id)->update($data);
      }  	

      public function deleteRec($id){
     $upRec=array('is_deleted'=>'1');
     $this->db->table('bus_company_routes')->where('id',$id)->update($upRec);
      }
}
