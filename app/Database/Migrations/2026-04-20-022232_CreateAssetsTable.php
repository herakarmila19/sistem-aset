<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssetsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'merk_barang' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tahun_pengadaan' => [
                'type'       => 'YEAR',
                'null'       => true,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'jenis_aset' => [
                'type'       => 'ENUM',
                'constraint' => ['non_aset', 'aset'],
                'default'    => 'aset',
            ],
            'kondisi' => [
                'type'       => 'ENUM',
                'constraint' => ['baik', 'rusak_ringan', 'rusak_berat'],
                'default'    => 'baik',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['ada', 'dipinjam', 'hilang'],
                'default'    => 'ada',
            ],
            'qr_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
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
        $this->forge->createTable('assets');
    }

    public function down()
    {
        $this->forge->dropTable('assets');
    }
}
