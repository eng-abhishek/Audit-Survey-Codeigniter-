<?php

namespace Modules\User\Controllers;

use App\Controllers\BaseController;
use Modules\User\Models\GroupModel;

class Groups extends BaseController
{
	public function __construct()
	{
		$this->groupModel = new GroupModel();
	}

	public function index()
	{
		$data = [
			'title' => 'User Groups',
			'records' => $this->groupModel->select('name, code, is_active, is_admin')->findAll()
		];
		return view('\Modules\User\Views\group_list', $data);
	}
}
