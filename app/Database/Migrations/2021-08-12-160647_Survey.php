<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Survey extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'survey_id' => [
				'type' => 'INT'
			],
			'name VARCHAR(100) NOT NULL',
			'frequency VARCHAR(20) NOT NULL',			
			'start_date DATETIME NOT NULL',
			'end_date DATETIME NOT NULL',			
			'is_completed TINYINT(1)',
			'completed_at DATETIME NULL',
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('survey_id', 'surveys', 'id');
		$this->forge->createTable('surveys', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('surveys', true);
	}
}
