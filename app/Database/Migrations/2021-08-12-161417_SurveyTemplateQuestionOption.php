<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SurveyTemplateQuestionOption extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'template_question_id' => [
				'type' => 'INT'
			],
			'value TEXT NOT NULL',
			'is_alert_notify TINYINT(1) NULL',
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('template_question_id', 'survey_template_questions', 'id');
		$this->forge->createTable('survey_template_question_options', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('survey_template_question_options', true);
	}
}
