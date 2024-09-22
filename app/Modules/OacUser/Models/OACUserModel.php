<?php

namespace Modules\OacUser\Models;

use CodeIgniter\Model;

class OACUserModel extends Model
{
    protected $table      = 'invites';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id','user_code', 'email', 'ref_token', 'active', 'invited_by','invited_on', 'status'];

    protected $useTimestamps = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}