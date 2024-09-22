<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Student extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],			
			'name VARCHAR(100) NOT NULL',
			'address TEXT NOT NULL',	
			'dob DATETIME NOT NULL',		
			'school_destination_id' => [
				'type' => 'INT'
			],
			'bus_route_id' => [
				'type' => 'INT'
			],
			'emergency_contact_name VARCHAR(100) NOT NULL',
			'emergency_contact_phone VARCHAR(20) NOT NULL',
			'special_transportations TEXT NOT NULL',
			'created_by' => [
				'type' => 'INT'
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('school_destination_id', 'school_destinations', 'id');
		$this->forge->addForeignKey('bus_route_id', 'bus_routes', 'id');
		$this->forge->addForeignKey('created_by', 'users', 'id');
		$this->forge->createTable('students', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('students', true);
	}
}
