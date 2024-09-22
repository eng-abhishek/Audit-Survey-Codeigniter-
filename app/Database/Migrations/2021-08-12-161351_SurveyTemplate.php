<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SurveyTemplate extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'name VARCHAR(100) NOT NULL',
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('survey_templates', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('survey_templates', true);
	}
}
