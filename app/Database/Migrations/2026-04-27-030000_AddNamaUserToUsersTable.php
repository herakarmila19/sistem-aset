<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNamaUserToUsersTable extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('nama_user', 'users')) {
            $this->forge->addColumn('users', [
                'nama_user' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => false,
                    'default' => 'Administrator',
                    'after' => 'username',
                ],
            ]);
        }

        $this->db->table('users')
            ->set('nama_user', 'Administrator')
            ->where('nama_user IS NULL OR nama_user = ""')
            ->update();
    }

    public function down()
    {
        if ($this->db->fieldExists('nama_user', 'users')) {
            $this->forge->dropColumn('users', 'nama_user');
        }
    }
}
