<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Group extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'name VARCHAR(100) NOT NULL',
			'code CHAR(3) NOT NULL',
			'description VARCHAR(100) NULL',
			'permissions TEXT NULL',
			'is_admin TINYINT(1)',
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('groups', TRUE);

		$data = [
			[
				'name' => 'Super Admin',
				'code' => 'SA',
				'is_admin' => 1
			],
			[
				'name' => 'Regional Transportation Coordinator',
				'code' => 'RTC',
				'is_admin' => NULL
			],
			[
				'name' => 'Regional Transportation Staff',
				'code' => 'RTS',
				'is_admin' => NULL
			],
			[
				'name' => 'Local Transportation Coordinator',
				'code' => 'LTC',
				'is_admin' => NULL
			],
			[
				'name' => 'Local Transportation Staff',
				'code' => 'LTS',
				'is_admin' => NULL
			],			
			[
				'name' => 'Onsite Audit Coordinator',
				'code' => 'OAC',
				'is_admin' => NULL
			],
			[
				'name' => 'Onsite Audit Staff',
				'code' => 'OAS',
				'is_admin' => NULL
			],
		];
		$this->db->table('groups')->insertBatch($data);
	}

	public function down()
	{
		$this->forge->dropTable('groups', true);
	}
}
