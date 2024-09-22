<?php

namespace Modules\Student\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
	protected $table = 'students';
    protected $db;
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $allowedFields        = ['first_name','last_name','student_state_id','state','city','zipcode','address1','address2','dob','email_id','school_destination_id','bus_route_id','assigned_ltc_id','assigned_rtc_id','emergency_contact_firstname','emergency_contact_lastname','emergency_contact_title','emergency_contact_phone','special_transportations','is_active'];


    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->configAuditSurvey = config('AuditSurvey');
    }

    public function insert_data($tablename='',$data = array())
    {
        $this->db->table($tablename)->insert($data);
        return $this->db->insertID();
    }

    public function update_data($id, $tablename='',$data = array())
    {
        $this->db->table($tablename)->update($data, array(
            "id" => $id,
        ));
        return $this->db->affectedRows();
    }


    public function update_where($tablename = '', $data=array(),$where=array()){

        $this->db->table($tablename)->update($data,$where);
        return $this->db->affectedRows();

    }


    public function delete_data($tablename='',$id)
    {
        return $this->db->table($tablename)->delete(array(
            "id" => $id,
        ));
    }

    public function get_all_data($tablename='')
    {
        $query = $this->db->query('select * from ' . $tablename);
        return $query->getResult();
    }

    public function insert_batch($tablename='', $data)
    {
        $this->db->table($tablename)->insertBatch($data);

    }

    public function get_datatable($tablename='')
    {
        $query = $this->db->table($tablename.' as a')->select('a.name, a.is_active, a.created_at, b.first_name ,  a.updated_at, c.first_name as updated_by, a.id')
        ->join('users as b','b.id = a.created_by','left')
        ->join('users as c','c.id = a.updated_by','left')
        ->where('deleted', 0)
        ->orderBy('id', 'DESC');
        return $query;
    }

    function filename_exists($templatename,$tablename='')
    {
        $result = $this->db->table($tablename)->select('*')->where('name', $templatename)->where('deleted', '0')->get()->getResultArray();

        return $result;
    }

}
