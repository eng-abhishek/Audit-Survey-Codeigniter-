<?php
namespace Modules\SchoolCalender\Models;
use CodeIgniter\Model;
error_reporting(1);
class SchoolCalenderModel extends Model
{
    protected $table      = 'school_calendar';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id','user_code', 'email', 'ref_token', 'active', 'invited_by','invited_on', 'status'];

    protected $useTimestamps = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function getDateList(){
    return $this->db->table('school_calendar')->select('id,type,start_date,end_date')->get()->getResultArray();
    }

    public function insertEvent(){
    extract($_POST);  
    $data=array(
    'type'=>$title,
    'start_date'=>$start,
    'end_date'=>$end,
    );  
    $this->db->table('school_calendar')->insert($data);
    }

    public function updateEvent(){
    extract($_POST);  
    $data=array(
    'type'=>$title,
    'start_date'=>$start,
    'end_date'=>$end,
    );  
    $this->db->table('school_calendar')->where('id',$id)->update($data);
    }

    public function removeEvent(){
    extract($_POST);
    $this->db->table('school_calendar')->where('id',$id)->delete();
    }
}