<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
        }

        $assetModel = new AssetModel();

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'total_barang' => $assetModel->countAll(),
            'barang_dipinjam' => $assetModel->where('status', 'dipinjam')->countAllResults(),
            'data_barang_tidak_ada' => 0,
            'barang_tersedia' => $assetModel->where('status', 'tersedia')->countAllResults(),
        ]);
    }
}
