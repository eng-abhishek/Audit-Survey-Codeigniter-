<?php

namespace Modules\BusCompany\Models;

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
}
