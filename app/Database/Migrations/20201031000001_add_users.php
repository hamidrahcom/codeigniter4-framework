<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsers extends Migration
{

    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
            ],
            'family'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
                'null'           => true,
            ],
            'email'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
            ],
            'password'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
            ],
            'role'      => [
                'type'           => 'ENUM',
                'constraint'     => ['user', 'admin', 'manager', 'fired'],
                'default'        => 'user',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
