<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        
        $assetModel = new AssetModel();
        
        $data['title'] = 'Dashboard';
        $data['total_barang'] = $assetModel->countAll();
        $data['barang_dipinjam'] = $assetModel->where('status', 'dipinjam')->countAllResults();
        $data['barang_hilang'] = $assetModel->where('status', 'hilang')->countAllResults();
        $data['barang_ada'] = $assetModel->where('status', 'ada')->countAllResults();
        
        return view('dashboard/index', $data);
    }
}
