<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = ['name', 'email'];

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

     public function get_datatable($tablename='',$userid)
    {
        $data = $this->db->table($this->configAuditSurvey->table_users.' as a');
        $data->select('CONCAT(a.first_name, " ", a.last_name) as name,a.id as userid,a.email as email,a.title_role as title,a.address as address,a.phone as phone,a.active as status,b.code as user_type,a.active as active,GROUP_CONCAT(d.district_name SEPARATOR ",") as districtname');
        $data->join($this->configAuditSurvey->table_groups.' as b','b.id = a.group_id');
        $data->join($this->configAuditSurvey->table_users_districts.' as c','c.user_id = a.id');
        $data->join($this->configAuditSurvey->table_districts.' as d','d.id = c.district_id');

        if($userid != '1')
        {
             $data->join($this->configAuditSurvey->table_users_mapping.' as e','e.user_id =a.id');
             $data->where('e.parent_user_id',$userid);
        }

        $data->where('a.is_deleted', '0');
        $data->where('c.status', '1');
        $data->groupBy('a.id');
        $data->orderBy('a.id', 'DESC');

        return $data;
    }

    public function getlistview($searchText = '',$sort_string = '', $page = '', $segment= '')
    {
        $data = $this->db->table($this->configAuditSurvey->table_users.' as a');
        $data->select('CONCAT(a.first_name, " ", a.last_name) as name,a.id as userid,a.email as email,a.title_role as title,a.address as address,a.phone as phone,a.active as status,b.code as user_type,a.active as active,GROUP_CONCAT(d.district_name SEPARATOR ",") as districtname');
        $data->join($this->configAuditSurvey->table_groups.' as b','b.id = a.group_id');
        $data->join($this->configAuditSurvey->table_users_districts.' as c','c.user_id = a.id');
        $data->join($this->configAuditSurvey->table_districts.' as d','d.id = c.district_id');
        if(!empty($searchText)) {
             $likeCriteria = "(a.first_name  LIKE '%".$searchText."%')";
            $data->where($likeCriteria);
        }
        $data->where('a.is_deleted', '0');
        $data->where('c.status', '1');
        $data->groupBy('a.id');
        $result = $data->get()->getResultArray();

        return $result;
    }


    public function getuserdata($id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_users.' as a')
        ->select('a.school_destination_id,a.id as userid,a.group_id,a.organization_name,a.billing_address_1,a.billing_address_2,a.billing_city,a.billing_state,a.billing_zipcode,a.website_url ,a.username, a.first_name, a.last_name,a.email, a.address, a.office_address1, a.city, a.state, a.gender, a.phone, a.fax, a.created_by, a.active, a.group_id, a.sms_survey_completion, a.sms_survey_alert, a.email_survey_completion, a.email_survey_alert, a.title_role, a.extension, a.office_address2,b.id as district_id, c.id as district_name,d.parent_user_id,a.zipcode')
        ->join($this->configAuditSurvey->table_users_districts.' as b','b.user_id = a.id','left')
        ->join($this->configAuditSurvey->table_districts.' as c','c.id = b.district_id','left')
        ->join($this->configAuditSurvey->table_users_mapping.' as d','d.user_id = a.id','left')
        ->where('a.id', $id)
        ->where('b.status', '1')
        ->get()->getResultArray();

        return $data;
    }

    public function update_data($id, $tablename='',$data = array())
    {
        $this->db->table($tablename)->update($data, array(
            "id" => $id,
        ));
        return $this->db->affectedRows();
    }

  

    public function getUserDistrict($id)
    {
    	$data = $this->db->table($this->configAuditSurvey->table_users_districts.' as a')
        ->select('a.id as district_id, b.district_name as district_name')
        ->join($this->configAuditSurvey->table_districts.' as b','b.id = a.district_id','left')
        ->where('a.user_id', $id)
        ->where('a.status', '1')
        ->get()->getResultArray();

        return $data;
    }

    public function getUserSchoolDestination($id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_users.' as a')
        ->select('b.school_name')
        ->join($this->configAuditSurvey->table_destination.' as b','b.id = a.school_destination_id','left')
        ->where('a.id', $id)
        ->get()->getResultArray();

        return $data;
    }


    public function getoasuserdata($id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_users.' as a')
        ->select('a.school_destination_id,a.id as userid,a.group_id,a.organization_name,a.billing_address_1,a.billing_address_2,a.billing_city,a.billing_state,a.billing_zipcode,a.website_url ,a.username, a.first_name, a.last_name,a.email, a.address, a.office_address1, a.city, a.state, a.gender, a.phone, a.fax, a.created_by, a.active, a.group_id, a.sms_survey_completion, a.sms_survey_alert, a.email_survey_completion, a.email_survey_alert, a.title_role, a.extension, a.office_address2,b.parent_user_id,a.zipcode')
        ->join($this->configAuditSurvey->table_users_mapping.' as b','b.user_id = a.id','left')
        ->where('a.id', $id)
        ->get()->getResultArray();

        return $data;
    }


    public function getUserDistricts($id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_users_districts.' as a')
        ->select('b.id,b.district_name')
        ->join($this->configAuditSurvey->table_districts.' as b','b.id = a.district_id','left')
        ->where('a.status', '1')
        ->where('a.user_id', $id)
        ->get()->getResultArray();

        return $data;
    }

    public function getCoordinatorData($id)
    {
       $data = $this->db->table($this->configAuditSurvey->table_users.' as a')
        ->select('a.school_destination_id,a.id as userid,a.group_id,a.organization_name,a.billing_address_1,a.billing_address_2,a.billing_city,a.billing_state,a.billing_zipcode,a.website_url ,a.username, a.first_name, a.last_name,a.email, a.address, a.office_address1, a.city, a.state, a.gender, a.phone, a.fax, a.created_by, a.active, a.group_id, a.sms_survey_completion, a.sms_survey_alert, a.email_survey_completion, a.email_survey_alert, a.title_role, a.extension, a.office_address2,b.parent_user_id,a.zipcode')
        ->join($this->configAuditSurvey->table_users_mapping.' as b','b.parent_user_id = a.id','left')
        ->where('b.user_id', $id)
        ->get()->getResultArray();

        return $data;
    }

    public function getwhere_record($tablename='',$where=array())
    {
        $result = $this->db->table($tablename)->where($where)->get()->getResultArray();

        return $result;
    }
}
