<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateStatusHilangToBelumDitemukan extends Migration
{
    public function up()
    {
        $this->db->query("UPDATE assets SET status = 'barang_belum_ditemukan' WHERE status = 'hilang'");
        $this->db->query("ALTER TABLE assets MODIFY status ENUM('ada','dipinjam','barang_belum_ditemukan') NOT NULL DEFAULT 'ada'");
    }

    public function down()
    {
        $this->db->query("UPDATE assets SET status = 'hilang' WHERE status = 'barang_belum_ditemukan'");
        $this->db->query("ALTER TABLE assets MODIFY status ENUM('ada','dipinjam','hilang') NOT NULL DEFAULT 'ada'");
    }
}
