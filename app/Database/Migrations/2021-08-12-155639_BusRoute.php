<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BusRoute extends Migration
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
			'start_date DATE NOT NULL',
			'end_date DATE NOT NULL',
			'shift VARCHAR(20) NULL',
			'vehicle_type VARCHAR(20) NULL',
			'regional_authority_id' => [
				'type' => 'INT'
			],
			'school_district_id' => [
				'type' => 'INT'
			],
			'bus_company_id' => [
				'type' => 'INT'
			],
			'school_destination_id' => [
				'type' => 'INT'
			],
			'managed_by' => [
				'type' => 'INT'
			],
			'created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL',
			'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'is_active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('incharge_id', 'users', 'id');
		$this->forge->addForeignKey('regional_authority_id', 'regional_authorities', 'id');
		$this->forge->addForeignKey('school_district_id', 'school_districts', 'id');
		$this->forge->addForeignKey('bus_company_id', 'bus_companies', 'id');
		$this->forge->addForeignKey('school_destination_id', 'school_destinations', 'id');
		$this->forge->addForeignKey('managed_by', 'users', 'id');
		$this->forge->createTable('bus_routes', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('bus_routes', true);
	}
}
