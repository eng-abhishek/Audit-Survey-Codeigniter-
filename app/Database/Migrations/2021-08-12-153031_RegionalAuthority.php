<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RegionalAuthority extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'name VARCHAR(100) NOT NULL',
			'billing_address TEXT NOT NULL',
			'created_by' => [
				'type' => 'INT'
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('created_by', 'users', 'id');
		$this->forge->createTable('regional_authorities', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('regional_authorities', true);
	}
}
