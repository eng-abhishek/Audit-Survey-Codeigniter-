<?php
namespace Modules\Test\Models;
use CodeIgniter\Model;

class TestModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'tbl_test';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'object';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ['name', 'email','address','city','state','is_active'];


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


	// public function get_datatable($tablename='')
 //    {
 //        $query = $this->db->table($tablename.' as a')->select('a.district_name,a.district_code,a.billing_address1,a.id,a.state,a.city,a.zipcode,a.district_url')
 //        ->orderBy('id', 'DESC');
 //        return $query;
 //    }

}
