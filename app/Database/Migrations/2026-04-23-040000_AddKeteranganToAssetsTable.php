<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeteranganToAssetsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('assets', [
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'default' => '',
                'after' => 'nama_barang',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('assets', 'keterangan');
    }
}
