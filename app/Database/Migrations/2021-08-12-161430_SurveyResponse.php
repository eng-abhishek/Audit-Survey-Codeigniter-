<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SurveyResponse extends Migration
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
			'incharge_id' => [
				'type' => 'INT'
			],
			'question_id' => [
				'type' => 'INT'
			],
			'answer TEXT NOT NULL',
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('survey_id', 'surveys', 'id');
		$this->forge->addForeignKey('incharge_id', 'users', 'id');
		$this->forge->addForeignKey('question_id', 'survey_template_questions', 'id');
		$this->forge->createTable('survey_responses', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('survey_responses', true);
	}
}
