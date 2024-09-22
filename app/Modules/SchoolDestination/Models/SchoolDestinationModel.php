<?php

namespace Modules\SchoolDestination\Models;
use CodeIgniter\Model;
class SchoolDestinationModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'school_destinations';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['school_name', 'address1','address2','state','city','zipcode','phone','extension','fax','email','office_phone','office_phone_ext','office_email','office_fax','active_routes','created_by','incharge_id','school_code','website_url','is_active'];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

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

    public function getOACIncharge($id){
    $query=$this->db->table('school_destinations')->select('incharge_id')->where('id',$id)->get()->getResult();
    $query02=$this->db->table('users')->select('first_name,last_name')->where('id',$query[0]->incharge_id)->get()->getResult();
    return $query02[0]->first_name.' '.$query02[0]->last_name;
    }

    public function getAssignedBusRoute($id){
    $query=$this->db->query('select count(a.id) as total_route from bus_company_routes a join bus_route_school_destination b ON b.route_id = a.id join school_destinations c ON c.id=b.school_destination_id where c.id="'.$id.'"')->getResult();
    return $query; 
    }

	public function getAllList(){
    $query=$this->db->query('select a.school_name,a.address1,b.username,c.state_name,a.city,a.id,a.is_active,a.school_code,a.office_phone,a.office_email,e.route_name from school_destinations a join users b ON b.id = a.incharge_id join master_states c ON c.id=a.state join bus_company_routes e ON e.id=a.active_routes where a.is_deleted=0 order by a.id desc')->getResult();
	return $query;
	}

	public function getdestinationList($col_name,$filterval){
    if($col_name=='username'){

    $query=$this->db->query('select a.school_name,a.address1,b.username,c.state_name,a.city,a.id,a.is_active,a.school_code,a.office_phone,a.office_email,e.route_name from school_destinations a join users b ON b.id = a.incharge_id join master_states c ON c.id=a.state join bus_company_routes e ON e.id=a.active_routes where b.'.$col_name.' like "%'.$filterval.'%" && a.is_deleted=0')->getResult();

    }elseif($col_name=='state_name'){

   $query=$this->db->query('select a.school_name,a.address1,b.username,c.state_name,a.city,a.id,a.is_active,a.school_code,a.office_phone,a.office_email,e.route_name from school_destinations a join users b ON b.id = a.incharge_id join master_states c ON c.id=a.state join bus_company_routes e ON e.id=a.active_routes where c.'.$col_name.' like "%'.$filterval.'%" && a.is_deleted=0')->getResult();

    }elseif($col_name=='city'){

   $query=$this->db->query('select a.school_name,a.address1,b.username,c.state_name,a.city,a.id,a.is_active,a.school_code,a.office_phone,a.office_email,e.route_name from school_destinations a join users b ON b.id = a.incharge_id join master_states c ON c.id=a.state join bus_company_routes e ON e.id=a.active_routes where d.'.$col_name.' like "%'.$filterval.'%" && a.is_deleted=0')->getResult();

    }elseif($col_name=='route_name'){

   $query=$this->db->query('select a.school_name,a.address1,b.username,c.state_name,a.city,a.id,a.is_active,a.school_code,a.office_phone,a.office_email,e.route_name from school_destinations a join users b ON b.id = a.incharge_id join master_states c ON c.id=a.state join bus_company_routes e ON e.id=a.active_routes where e.'.$col_name.' like "%'.$filterval.'%" && a.is_deleted=0')->getResult();

    }elseif($col_name=='school_name' || $col_name=='school_code' || $col_name=='address1' || $col_name=='office_phone' || $col_name=='office_email' || $col_name=='office_email'){

   $query=$this->db->query('select a.school_name,a.address1,b.username,c.state_name,a.city,a.id,a.is_active,a.school_code,a.office_phone,a.office_email,e.route_name from school_destinations a join users b ON b.id = a.incharge_id join master_states c ON c.id=a.state join bus_company_routes e ON e.id=a.active_routes where a.'.$col_name.' like "%'.$filterval.'%" && a.is_deleted=0')->getResult();
    }
// echo"";  
// print_r($query);
    $output='';
    foreach ($query as $key=>$value){
	if($value->is_active == '1'){
	$val="checked";
	}else{
	$val="";
	}
	 $index=$key+1;
	 $edit=base_url('school-destination/edit/' . base64_encode($value->id));
     $view=base_url('school-destination/view/' . base64_encode($value->id));
     $del=base_url('school-destination/delete/' . base64_encode($value->id));
                                $output.='<tr>
                                <td>'.$index.'</td>
                                <td>'.$value->school_name.'</td>
                                <td>'.$value->school_code.'</td>
                                <td>'.$value->address1.'</td>
                                <td>'.$value->state_name.'</td>
                                <td>'.$value->city.'</td>
                                <td>'.$value->username.'</td>
                                <td>'.$value->office_phone.'</td>
                                <td>'.$value->office_email.'</td>
                                <td>'.$value->route_name.'</td>
                                <td>
                                <div class="custom-control custom-switch">
                                <input type="checkbox" class="destinationStatus custom-control-input" data-status="'.$value->is_active.'" name="status'.$value->id.'" id="status'.$value->id.'" '.$val.' data-did="'.$value->id.'"><label class="custom-control-label" for="status'.$value->id.'"></label>
                                <input type="text" name="sid'.$value->id.'" id="sid'.$value->id.'" hidden value="'.$value->is_active.'">
                                </div>
                               </td>
                               <td>
                            <a href="'.$edit.'"><i class="fas fa-edit"></i></a>
                            <a href="'.$view.'"><i class="far fa-eye"></i></a>
                            <a href="'.$del.'"><i class="fas fa-trash"></i></a>    
                               </td>
                               </tr>';
    }
    return $output;
	}

    public function get_datatable($tablename='')
    {
        $query = $this->db->table($tablename.' as a')->select('a.school_name,a.address1,a.state as des_state,a.id,a.is_active,b.username,a.city as des_city,a.school_code,a.office_phone,a.office_email,a.active_routes')
        ->join('users as b','b.id = a.incharge_id ','left')
        ->where('a.is_deleted','0')
        ->orderBy('id', 'DESC');
        return $query;
    }
 
    public function deleteRecord($id){
     $upRec=array('is_deleted'=>'1');
     $this->db->table('school_destinations')->where('id',$id)->update($upRec);
     }

    public function getAllRoute(){
    $allActiveRoute=$this->db->table('bus_company_routes')->select('id,route_name')->where('is_deleted','0')->where('is_active','1')->get()->getResult();
    return $allActiveRoute;
     }

     public function getState(){
     return $this->db->table('master_states')->select('*')->get()->getResult();
       }

     public function getAllCity($id){
     return $this->db->table('master_cities')->select('*')->where('id_state',$id)->get()->getResult();
       }

     public function getCity($id){
     return $this->db->table('master_cities')->select('*')->where('id_state',$id)->get()->getResult();
     }

}
