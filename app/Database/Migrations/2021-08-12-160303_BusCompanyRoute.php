<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BusCompanyRoute extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true,
			],			
			'start_date DATETIME NOT NULL',
			'end_date DATETIME NOT NULL',			
			'bus_company_id' => [
				'type' => 'INT'
			],
			'bus_route_id' => [
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
		$this->forge->addForeignKey('bus_company_id', 'bus_companies', 'id');
		$this->forge->addForeignKey('bus_route_id', 'bus_routes', 'id');
		$this->forge->addForeignKey('managed_by', 'users', 'id');
		$this->forge->createTable('bus_company_routes', TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('bus_company_routes', true);
	}
}
