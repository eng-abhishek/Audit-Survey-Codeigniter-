<?php

namespace Modules\SurveyTemplate\Models;

use CodeIgniter\Model;

class SurveyTemplateModel extends Model
{
	protected $table = 'survey_templates';
    protected $db;
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'object';
    protected $allowedFields        = ['deleted'];


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

    public function getsurveytemplate($template_id)
    {
        $data = $this->db->table($this->configAuditSurvey->table_survey_template.' as a')
        ->select('a.id as template_id,a.is_active as template_status,a.name as template_name,b.id as question_id,b.question as question_label,b.question_type as question_type,is_required as mandatory,c.id as option_id,c.value as option_value,c.is_alert_notify as alert_notify,c.is_end_notify as end_notify,c.alert_notes as alert_notes,c.end_audit_notes as end_notes,c.is_active as optionactive')
        ->join($this->configAuditSurvey->table_survey_template_questions.' as b','b.survey_template_id = a.id','left')
        ->join($this->configAuditSurvey->table_survey_template_options.' as c','c.template_question_id = b.id','left')
        ->where('b.is_active', '1')
        ->where('b.is_system_generated', '0')
        ->where('a.id', $template_id)
        ->get()->getResultArray();

        return $data;
       
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
        $result = $this->db->table($tablename)->select('*')->where('name', $templatename)->get()->getResultArray();

        return $result;
    }

    public function getwhere_record_count($tablename='',$where=array())
    {
        $result = $this->db->table($tablename)->where($where)->countAllResults();

        return $result;
    }

}
