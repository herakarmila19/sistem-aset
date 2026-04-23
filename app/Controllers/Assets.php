<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
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
        $data = [
            'years' => range($tahunSekarang - 20, $tahunSekarang),
            'validation' => \Config\Services::validation(),
        ];
        return view('assets/create', $data);
    }

    public function store()
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        
        $rules = [
            'nama_barang' => 'required|min_length[3]',
            'merk_barang' => 'permit_empty|max_length[255]',
            'tahun_pengadaan' => 'permit_empty|integer',
            'jenis_aset' => 'required|in_list[aset,non_aset]',
            'kondisi' => 'required|in_list[baik,rusak_ringan,rusak_berat]',
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,5120]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/barang/create')->withInput()->with('error', 'Validasi gagal. Periksa kembali input form.');
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
        $assetModel->insert($data);
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

        return redirect()->to('/barang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function show($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        $assetModel = new AssetModel();
        $data['asset'] = $assetModel->find($id);
        if (!$data['asset']) {
            return redirect()->to('/barang')->with('error', 'Data barang tidak ditemukan.');
        }
        return view('assets/show', $data);
    }

    public function edit($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        $assetModel = new AssetModel();
        $data['asset'] = $assetModel->find($id);
        if (!$data['asset']) {
            return redirect()->to('/barang')->with('error', 'Data barang tidak ditemukan.');
        }
        $tahunSekarang = date('Y');
        $data['years'] = range($tahunSekarang - 20, $tahunSekarang);
        $data['validation'] = \Config\Services::validation();
        return view('assets/edit', $data);
    }

    public function update($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);
        if (!$asset) {
            return redirect()->to('/barang')->with('error', 'Data barang tidak ditemukan.');
        }

        $rules = [
            'nama_barang' => 'required|min_length[3]',
            'merk_barang' => 'permit_empty|max_length[255]',
            'tahun_pengadaan' => 'permit_empty|integer',
            'jenis_aset' => 'required|in_list[aset,non_aset]',
            'kondisi' => 'required|in_list[baik,rusak_ringan,rusak_berat]',
            'status' => 'required|in_list[ada,dipinjam,hilang]',
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,5120]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/barang/' . $id . '/edit')->withInput()->with('error', 'Validasi gagal. Periksa kembali input form.');
        }
        
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

        return redirect()->to('/barang')->with('success', 'Barang berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);
        if (!$asset) {
            return redirect()->to('/barang')->with('error', 'Data barang tidak ditemukan.');
        }
        
        // Hapus foto
        if ($asset['foto'] && file_exists(FCPATH . 'uploads/' . $asset['foto'])) {
            unlink(FCPATH . 'uploads/' . $asset['foto']);
        }
        
        // Hapus QR code
        if ($asset['qr_code'] && file_exists(FCPATH . 'uploads/' . $asset['qr_code'])) {
            unlink(FCPATH . 'uploads/' . $asset['qr_code']);
        }
        
        $assetModel->delete($id);

        return redirect()->to('/barang')->with('success', 'Barang berhasil dihapus');
    }
}
