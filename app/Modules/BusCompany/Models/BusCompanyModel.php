<?php

namespace Modules\BusCompany\Models;

use CodeIgniter\Model;

class BusCompanyModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'bus_companies';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['company_name', 'email', 'address1', 'address2', 'created_by','city','state','zipcode','phone','extension','school_district_id','contractor_code','is_active','deleted'];

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


	public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->configAuditSurvey = config('AuditSurvey');
    }

	public function get_all_data($tablename='')
    {
        $query = $this->db->query('select * from ' . $tablename);
        return $query->getResultArray();
    }


    function getwhere_data($tablename='',$condition,$value)
    {
        $result = $this->db->table($tablename)->select('*')->where($condition, $value)->get()->getResultArray();

        return $result;
    }

     public function get_datatable_bus_company($tablename='')
    {
        $query = $this->db->table($tablename.' as a')->select('a.company_name, a.email, a.address1, a.phone,a.is_active,a.id')
        ->join($this->configAuditSurvey->table_state_master.' as b','b.id = a.state','left')
        ->join($this->configAuditSurvey->table_city_master.' as c','c.id = a.city','left')
        ->where('deleted', 0)
        ->orderBy('id', 'DESC');
        return $query;
    }

     public function deleteRecord($id){
     $upRec=array('is_deleted'=>'1');
     $this->db->table('bus_company_routes')->where('id',$id)->update($upRec);
     }
}
