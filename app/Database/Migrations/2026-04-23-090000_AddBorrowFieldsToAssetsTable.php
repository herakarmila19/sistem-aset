<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBorrowFieldsToAssetsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('assets', [
            'nama_peminjam' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'qr_code',
            ],
            'keperluan_pinjam' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'nama_peminjam',
            ],
            'dipinjam_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'keperluan_pinjam',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('assets', ['nama_peminjam', 'keperluan_pinjam', 'dipinjam_at']);
    }
}
