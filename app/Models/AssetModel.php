<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nama_barang',
        'keterangan',
        'merk_barang',
        'tahun_pengadaan',
        'foto',
        'jenis_aset',
        'kondisi',
        'status',
        'qr_code',
    ];
}
