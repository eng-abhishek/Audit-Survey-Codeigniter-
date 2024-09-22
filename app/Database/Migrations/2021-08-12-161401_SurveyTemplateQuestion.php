<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SurveyTemplateQuestion extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],
			'survey_template_id' => [
				'type' => 'INT'
			],
			'question TEXT NOT NULL',
			'question_type' => [
				'type' => 'ENUM("Text", "Textarea", "Email", "Number", "Dropdown", "Datepicker", "Checkbox", "Radio")',
				'default' => 'Text',
				'null' => FALSE
			],
			'is_required TINYINT(1) NULL',
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('survey_template_id', 'survey_templates', 'id');
		$this->forge->createTable('survey_template_questions', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('survey_template_questions', true);
	}
}
