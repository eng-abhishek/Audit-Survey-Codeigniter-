<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SchoolDestination extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'incharge_id' => [
				'type' => 'INT'
			],
			'name VARCHAR(100) NOT NULL',
			'address TEXT NOT NULL',
			'phone VARCHAR(20) NOT NULL',
			'fax VARCHAR(20) NULL',
			'created_by' => [
				'type' => 'INT'
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('incharge_id', 'users', 'id');
		$this->forge->addForeignKey('created_by', 'users', 'id');
		$this->forge->createTable('school_destinations', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('school_destinations', true);
	}
}
