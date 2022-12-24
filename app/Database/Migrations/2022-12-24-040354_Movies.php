<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Movies extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
			'id'                 => [
				'type'           => 'INT',
				'constraint'     => 10,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'title'              => [
				'type'           => 'VARCHAR',
				'constraint'     => '255'
			],
			'description'        => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => true,
			],
			'rating'             => [
				'type'           => 'DECIMAL',
                'constraint'     => '10,2',
				'null'           => false,
                'default'        => '0.0'
			],
			'image'              => [
				'type'           => 'VARCHAR',
				'constraint'     => '255',
				'null'           => true,
			],
            'created_date datetime default current_timestamp',
            'updated_date datetime default current_timestamp on update current_timestamp',
		]);

		$this->forge->addKey('id', TRUE);

		$this->forge->createTable('movies', TRUE);
    }

    public function down()
    {
        //
    }
}
