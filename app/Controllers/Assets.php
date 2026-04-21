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
        $tahunSekarang = date('Y');
        $data['years'] = range($tahunSekarang - 20, $tahunSekarang);
        return view('assets/create', $data);
    }

    public function store()
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        
        $file = $this->request->getFile('foto');
        $fotoName = null;
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $fotoName = $newName;
        }
        
        $assetModel = new AssetModel();
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'merk_barang' => $this->request->getPost('merk_barang'),
            'tahun_pengadaan' => $this->request->getPost('tahun_pengadaan'),
            'foto' => $fotoName,
            'jenis_aset' => $this->request->getPost('jenis_aset'),
            'kondisi' => $this->request->getPost('kondisi'),
            'status' => 'ada',
        ];
        $assetModel->save($data);
        $id = $assetModel->getInsertID();

        // Generate QR code
        $qrCode = QrCode::create((string)$id);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $fileName = 'qr_' . $id . '.png';
        $filePath = FCPATH . 'uploads/' . $fileName;
        $result->saveToFile($filePath);

        // Update asset with QR path
        $assetModel->update($id, ['qr_code' => $fileName]);

        return redirect()->to('/assets')->with('success', 'Barang berhasil ditambahkan');
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

    public function edit($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        $assetModel = new AssetModel();
        $data['asset'] = $assetModel->find($id);
        $tahunSekarang = date('Y');
        $data['years'] = range($tahunSekarang - 20, $tahunSekarang);
        return view('assets/edit', $data);
    }

    public function update($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);
        
        $file = $this->request->getFile('foto');
        $fotoName = $asset['foto'];
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus foto lama jika ada
            if ($asset['foto'] && file_exists(FCPATH . 'uploads/' . $asset['foto'])) {
                unlink(FCPATH . 'uploads/' . $asset['foto']);
            }
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $fotoName = $newName;
        }
        
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'merk_barang' => $this->request->getPost('merk_barang'),
            'tahun_pengadaan' => $this->request->getPost('tahun_pengadaan'),
            'foto' => $fotoName,
            'jenis_aset' => $this->request->getPost('jenis_aset'),
            'kondisi' => $this->request->getPost('kondisi'),
            'status' => $this->request->getPost('status'),
        ];
        $assetModel->update($id, $data);

        return redirect()->to('/assets')->with('success', 'Barang berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);
        
        // Hapus foto
        if ($asset['foto'] && file_exists(FCPATH . 'uploads/' . $asset['foto'])) {
            unlink(FCPATH . 'uploads/' . $asset['foto']);
        }
        
        // Hapus QR code
        if ($asset['qr_code'] && file_exists(FCPATH . 'uploads/' . $asset['qr_code'])) {
            unlink(FCPATH . 'uploads/' . $asset['qr_code']);
        }
        
        $assetModel->delete($id);

        return redirect()->to('/assets')->with('success', 'Barang berhasil dihapus');
    }
}
