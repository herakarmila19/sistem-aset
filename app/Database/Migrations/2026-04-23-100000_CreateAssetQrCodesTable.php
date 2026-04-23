<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssetQrCodesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'asset_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'qr_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'qr_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('asset_id');
        $this->forge->addForeignKey('asset_id', 'assets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('asset_qr_codes');
    }

    public function down()
    {
        $this->forge->dropTable('asset_qr_codes', true);
    }
}
