<?php

namespace Modules\OacUser\Models;

use CodeIgniter\Model;

class InvitesRegisterModel extends Model
{
    protected $table      = 'invites_register';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    //protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'invite_id', 'user_id', 'school_district_id', 'school_destination_id','first_name','last_name','title_role','office_address1','office_address2','city','state','zipcode','phone','extension','fax','email','extension','registration_status','created_on','invited_by','sms_survey_completion','sms_survey_alert','email_survey_completion','email_survey_alert'];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getrecordCount() {
        $this->select('*');
        $this->where('registration_status', '0');
        $query = $this->get();
        return $query->getNumRows();
    }


    public function get_datatable_oac_register($userid='')
    {
       $data = $this->db->table('invites_register as a')
        ->select('a.first_name,a.last_name,a.id,b.school_name,c.district_name,CONCAT(a.first_name, " ", a.last_name) as name,a.registration_status')
        ->join('school_destinations as b','b.id = a.school_destination_id','left')
        ->join('school_districts as c','c.id = a.school_district_id','left');

        if($userid != '1')
        {
            $data->where('a.invited_by',$userid);
        }
        $data->orderBy('a.id', 'DESC');

        return $data;
    }

}