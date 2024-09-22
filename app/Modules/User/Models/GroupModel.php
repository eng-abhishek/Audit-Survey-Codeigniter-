<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'groups';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['name', 'code', 'permissions', 'is_admin'];

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

    public function insert_data($tablename='',$data = array())
    {
        $this->db->table($tablename)->insert($data);
        return $this->db->insertID();
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

    public function update_data($id, $tablename='',$data = array())
    {
        $this->db->table($tablename)->update($data, array(
            "id" => $id,
        ));
        return $this->db->affectedRows();
    }

    public function update_data_where($tablename='',$data = array(),$where=array())
    {
        $this->db->table($tablename)->update($data, $where);
        return $this->db->affectedRows();
    }
    
    public function update_global($where, $tablename='',$data = array())
    {
        $this->db->table($tablename)->update($data, $where);
        return $this->db->affectedRows();
    }


    public function getwhere_data($tablename='',$condition,$value)
    {
        $result = $this->db->table($tablename)->select('*')->where($condition, $value)->get()->getResultArray();

        return $result;
    }

    public function getwhere_multiple($tablename='',$where=array())
    {
		$result = $this->db->table($tablename)->getWhere($where)->getRow();

        return $result;
    }


}
