<?php
namespace Modules\SchoolDistrict\Models;
use CodeIgniter\Model;

class SchoolDistrictModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'school_districts';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['district_name', 'billing_address1','billing_address2','city','state','zipcode','district_code','district_url','is_active','created_by'];
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

	public function get_datatable($tablename='')
    {
        $query=$this->db->table('school_districts a')->select('a.city,a.district_name,a.district_code,a.billing_address1,a.id,b.state_name,a.zipcode,a.district_url')->join('master_states b','b.id=a.state')->where('a.is_deleted','0')->orderBy('a.id','DESC')->get()->getResult();
        return $query; 
    }
 
	public function listofDistrictDB($col_name,$value){
    if($col_name=='state_name'){

    $query=$this->db->query('select a.district_name,a.district_code,a.billing_address1,a.id,b.state_name,a.city,a.zipcode,a.district_url from school_districts a join master_states b ON b.id=a.state where b.'.$col_name.' like"%'.$value.'%" && a.is_deleted=0')->getResult();
 
    }else{

    $query=$this->db->query('select a.district_name,a.district_code,a.billing_address1,a.id,b.state_name,a.city,a.zipcode,a.district_url from school_districts a join master_states b ON b.id=a.state where a.'.$col_name.' like"%'.$value.'%" && a.is_deleted=0')->getResult();
         }
	$output='';
	if($query){
	foreach ($query as $key => $value){
	$view=base_url("districts/view/" . base64_encode($value->id));
	$edit=base_url("districts/edit/" . base64_encode($value->id));
	$del=base_url("districts/delete/" . base64_encode($value->id));
    $index=$key+1;
	$output.='<tr>
	<td>'.$index.'</td>
	<td>'.$value->district_name.'</td>
	<td>'.$value->district_code.'</td>
	<td>'.$value->billing_address1.'</td>
	<td>'.$value->state_name.'</td> 
	<td>'.$value->city.'</td>
	<td>'.$value->zipcode.'</td> 
	<td>'.$value->district_url.'</td> 
	<td>
	<a href="'.$view.'"><i class="fas fa-eye"></i></a>
	<a href="'.$edit.'"><i class="fas fa-edit"></i></a>
	<a href="'.$del.'" class="del_template"><i class="fas fa-trash"></i></a>
	</td> 
	</tr>';
			} }
	echo $output;
	}

	 public function deleteRecord($id){
     $upRec=array('is_deleted'=>'1');
     $this->db->table('school_districts')->where('id',$id)->update($upRec);
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

     public function getList(){
      $this->db->table('school_districts a')->select('a.district_name,a.district_code,a.billing_address1,a.id,s.state_name as state,c.city as city,a.zipcode,a.district_url')->join('master_states s','s.id=a.state')->join('master_cities c','c.id=a.city')->where('a.is_deleted','0')->get()->getResult();
     }

     public function checkDestrictUse($id){
     return $this->db->table('user_districts')->where('district_id',$id)->get()->getResultArray();
     }

     public function checkDuplicateCode(){
     extract($_POST);
     $data=$this->db->query('select count(id) as id from school_districts where district_code ="'.$district_code.'"')->getResultArray();
     return $data[0]['id'];
        }

    public function checkDuplicateCodeOnEdit(){
    extract($_POST);
    $data=$this->db->query('select count(id) as id from school_districts where district_code ="'.$district_code.'" && id ="'.$id.'" ')->getResultArray();	
    return $data[0]['id'];
    }

}
