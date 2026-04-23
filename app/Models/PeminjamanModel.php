<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'barang_id',
        'nama_peminjam',
        'keperluan',
        'tanggal_pinjam',
        'tanggal_kembali',
        'foto_pengembalian',
    ];
}
