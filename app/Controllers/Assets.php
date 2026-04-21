<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use CodeIgniter\HTTP\ResponseInterface;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Assets extends BaseController
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        $assetModel = new AssetModel();
        $data['assets'] = $assetModel->findAll();
        return view('assets/index', $data);
    }

    public function create()
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        return view('assets/create');
    }

    public function store()
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        $assetModel = new AssetModel();
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'jenis_barang' => $this->request->getPost('jenis_barang'),
        ];
        $assetModel->save($data);
        $id = $assetModel->getInsertID();

        // Generate QR code
        $qrCode = QrCode::create($id);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $fileName = 'qr_' . $id . '.png';
        $filePath = FCPATH . 'uploads/' . $fileName;
        $result->saveToFile($filePath);

        // Update asset with QR path
        $assetModel->update($id, ['qr_code' => $fileName]);

        return redirect()->to('/assets');
    }

    public function show($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        $assetModel = new AssetModel();
        $data['asset'] = $assetModel->find($id);
        return view('assets/show', $data);
    }
}
