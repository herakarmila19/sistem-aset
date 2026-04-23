<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeminjamanAndAdjustAssetStatus extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('status', 'assets')) {
            $this->forge->addColumn('assets', [
                'status' => [
                    'type' => 'ENUM',
                    'constraint' => ['tersedia', 'dipinjam'],
                    'default' => 'tersedia',
                    'after' => 'kondisi',
                ],
            ]);
        }

        if (!$this->db->fieldExists('qr_code', 'assets')) {
            $this->forge->addColumn('assets', [
                'qr_code' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'status',
                ],
            ]);
        }

        $this->db->query("UPDATE assets SET status = 'tersedia' WHERE status IN ('ada', 'barang_belum_ditemukan', 'hilang') OR status IS NULL");
        $this->db->query("ALTER TABLE assets MODIFY status ENUM('tersedia','dipinjam') NOT NULL DEFAULT 'tersedia'");

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'barang_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'nama_peminjam' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'keperluan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_pinjam' => [
                'type' => 'DATETIME',
            ],
            'tanggal_kembali' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'foto_pengembalian' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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
        $this->forge->addKey('barang_id');
        $this->forge->addForeignKey('barang_id', 'assets', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peminjaman', true);
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman', true);
        $this->db->query("ALTER TABLE assets MODIFY status ENUM('ada','dipinjam','barang_belum_ditemukan') NOT NULL DEFAULT 'ada'");
        $this->db->query("UPDATE assets SET status = 'ada' WHERE status = 'tersedia'");
    }
}
