<?php

namespace Modules\Survey\Models;

use CodeIgniter\Model;

class CustomModel extends Model
{
	public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        $this->configAuditSurvey = config('AuditSurvey');
    }

	
    public function getwhere_record($tablename='',$where=array())
    {
        $result = $this->db->table($tablename)->where($where)->get()->getResultArray();

        return $result;
    }

    public function insert_batch($tablename='', $data)
    {
        $this->db->table($tablename)->insertBatch($data);

    }

    public function get_datatable($tablename='')
    {
        $query = $this->db->table($tablename.' as a')->select('a.id,a.name,a.start_date, a.end_date, a.is_active,b.name as survey_template_name,CONCAT(c.first_name, " ", c.last_name) as created_by,GROUP_CONCAT(DISTINCT e.coordinator_id SEPARATOR ",") as coordinator_id,GROUP_CONCAT(DISTINCT f.first_name, " ", f.last_name) as coordinator_names,GROUP_CONCAT(DISTINCT g.code) as coordinator_roles,GROUP_CONCAT(DISTINCT i.district_name) as coordinator_districts')
        ->join($this->configAuditSurvey->table_survey_template.' as b','b.id = a.survey_id','left')
        ->join($this->configAuditSurvey->table_users.' as c','c.id = a.created_by','left')
        ->join($this->configAuditSurvey->table_busroute_survey.' as d','d.surveys_id = a.id','left')
        ->join($this->configAuditSurvey->table_bus_company.' as e','e.id = d.bus_route_id','left')
        ->join($this->configAuditSurvey->table_users.' as f','f.id = e.coordinator_id','left')
        ->join($this->configAuditSurvey->table_groups.' as g','g.id = f.group_id','left')
        ->join($this->configAuditSurvey->table_users_districts.' as h','h.user_id = f.id','left')
        ->join($this->configAuditSurvey->table_districts.' as i','i.id = h.district_id','left')
        ->where('d.is_deleted', 0)
        ->where('a.is_deleted', 0)
        ->groupBy('a.id')
        ->orderBy('a.id', 'DESC');

        return $query;
    }

    public function get_survey($id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_survey.' as a');
        $data->select('a.*,GROUP_CONCAT(DISTINCT c.survey_shifts) as shifts,GROUP_CONCAT(DISTINCT b.bus_route_id) as bus_route,GROUP_CONCAT(DISTINCT d.route_name) as bus_route_name',FALSE);
        $data->join($this->configAuditSurvey->table_busroute_survey.' as b','b.surveys_id = a.id','left');
        $data->join($this->configAuditSurvey->table_survey_shift.' as c','c.survey_id = a.id','left');
         $data->join($this->configAuditSurvey->table_bus_company.' as d','d.id = b.bus_route_id','left');
        $data->where('a.id', $id);
        $data->where('a.is_deleted', '0');
        $data->where('b.is_deleted', '0');
        $data->where('c.status', '1');
        $result = $data->get()->getResultArray();

        return $result;

    }

    public function update_global($where, $tablename='',$data = array())
    {
        $this->db->table($tablename)->update($data, $where);
        return $this->db->affectedRows();
    }


    public function getuserByRoute($route_id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_users.' as a');
        $data->select('a.id,a.school_destination_id');
        $data->join($this->configAuditSurvey->table_route_destination.' as b','b.school_destination_id = a.school_destination_id','left');
        $data->where('b.route_id', $route_id);
        $data->where('a.is_deleted', '0');
        $result = $data->get()->getResultArray();

        return $result;
    }

    public function get_survey_table($survey_id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_busroute_survey.' as a');
        $data->select('a.id,d.school_name,c.route_name,e.company_name');
        $data->join($this->configAuditSurvey->table_route_destination.' as b','b.route_id = a.bus_route_id','left');
        $data->join($this->configAuditSurvey->table_bus_company.' as c','c.id = b.route_id','left');
        $data->join($this->configAuditSurvey->table_destination.' as d','d.id = b.school_destination_id','left');
        $data->join($this->configAuditSurvey->table_bus_companies.' as e','e.id = c.bus_company_id','left');

        $data->where('a.surveys_id', $survey_id);
        $data->where('a.is_deleted', '0');
        $result = $data->get()->getResultArray();

        return $result;
    }

    public function get_coordinators($route_id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_bus_company.' as a');
        $data->select('c.code,GROUP_CONCAT(DISTINCT e.district_name) as district_name');
        $data->join($this->configAuditSurvey->table_users.' as b','b.id = a.coordinator_id','left');
        $data->join($this->configAuditSurvey->table_groups.' as c','c.id = b.group_id','left');
        $data->join($this->configAuditSurvey->table_users_districts.' as d','d.user_id = b.id','left');
        $data->join($this->configAuditSurvey->table_districts.' as e','e.id = d.district_id','left');
        
        $data->where('a.id', $route_id);
        $data->where('a.is_deleted', '0');
        $result = $data->get()->getResultArray();

        return $result;
    }
}
