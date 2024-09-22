<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'INT',
				'auto_increment' => true
			],			
			'username VARCHAR(100) NOT NULL',
			'name VARCHAR(100) NOT NULL',
			'email' => [
				'type' => 'VARCHAR',
				'constraint' => 100,
				'unique'         => true
			],
			'password VARCHAR(220) NOT NULL',			
			'address TEXT NOT NULL',
			'office_address TEXT NOT NULL',
			'age TINYINT(1) NOT NULL',
			'gender VARCHAR(10) NOT NULL',
			'phone VARCHAR(20) NOT NULL',
			'fax VARCHAR(20) NULL',
			'created_by' => [
				'type' => 'INT'
			],
			'activation_selector' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => true,
				'unique'     => true,
			],
			'activation_code' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => true,
			],
			'forgotten_password_selector' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => true,
				'unique'     => true,
			],
			'forgotten_password_code' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => true,
			],
			'forgotten_password_time' => [
				'type'       => 'INT',
				'constraint' => '11',
				'unsigned'   => true,
				'null'       => true,
			],
			'remember_selector' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => true,
				'unique'     => true,
			],
			'remember_code' => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null'       => true,
			],
			'last_login INT NULL',
			'ip_address VARCHAR(45) NULL',
			'created_on INT',
			'updated_at DATETIME default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL',
			'deleted_at DATETIME NULL',
			'is_deleted TINYINT(1) DEFAULT 0 NOT NULL',
			'active TINYINT(1) DEFAULT 1 NOT NULL'
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('created_by', 'users', 'id');
		$this->forge->createTable('users', TRUE);

		$data = [
			'username' => 'admin',
			'name' => 'Super Admin',
			'email' => 'silambarasan@g2techsoft.com',
			'password' => password_hash('123456', PASSWORD_BCRYPT),
			'address'=> 'PO Box 2180, Flemington, NJ 08822',
			'office_address' => 'PO Box 2180, Flemington, NJ 08822',
			'age' => 30,
			'gender' => 'Male',
			'phone' => '908-923-0655',
			'created_by' => 1,
			'created_on' => time(),

		];
		$this->db->table('users')->insert($data, TRUE);
	}

	public function down()
	{
		$this->forge->dropTable('users', true);
	}
}
