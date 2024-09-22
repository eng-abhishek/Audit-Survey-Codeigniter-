<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserGroup extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'auto_increment' => true,
			],
			'user_id' => [
				'type'       => 'INT',
			],
			'group_id' => [
				'type'       => 'INT',
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('user_id', 'users', 'id', 'NO ACTION', 'CASCADE');
		$this->forge->addForeignKey('group_id', 'groups', 'id', 'NO ACTION', 'CASCADE');
		$this->forge->createTable('user_groups', TRUE);

		$data = [
			'user_id' => 1,
			'group_id' => 1
		];
		$this->db->table('user_groups')->insert($data, TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('user_groups', true);
	}
}
