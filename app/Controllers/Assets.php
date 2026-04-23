<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Assets extends BaseController
{
    private function processUploadedImageToWebp(?\CodeIgniter\HTTP\Files\UploadedFile $file, ?string $existingFile = null): ?string
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $existingFile;
        }

        $imageInfo = @getimagesize($file->getTempName());
        if ($imageInfo === false) {
            return $existingFile;
        }

        $binary = @file_get_contents($file->getTempName());
        if ($binary === false) {
            return $existingFile;
        }

        $imageResource = @imagecreatefromstring($binary);
        if (!$imageResource) {
            return $existingFile;
        }

        imagepalettetotruecolor($imageResource);
        imagealphablending($imageResource, true);
        imagesavealpha($imageResource, true);

        $uploadDir = FCPATH . 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $targetName = pathinfo($file->getRandomName(), PATHINFO_FILENAME) . '.webp';
        $targetPath = $uploadDir . $targetName;
        $quality = 85;
        $maxBytes = 75 * 1024;
        $attempt = 0;
        $size = 0;

        do {
            imagewebp($imageResource, $targetPath, $quality);
            clearstatcache(true, $targetPath);
            $size = file_exists($targetPath) ? filesize($targetPath) : 0;

            if ($size <= $maxBytes) {
                break;
            }

            if ($quality > 35) {
                $quality -= 5;
            } else {
                $scaledWidth = max(320, (int) floor(imagesx($imageResource) * 0.9));
                $scaledHeight = max(320, (int) floor(imagesy($imageResource) * 0.9));
                $scaledImage = imagescale($imageResource, $scaledWidth, $scaledHeight, IMG_BICUBIC);
                if ($scaledImage !== false) {
                    imagedestroy($imageResource);
                    $imageResource = $scaledImage;
                } else {
                    break;
                }
            }

            $attempt++;
        } while ($attempt < 15);

        imagedestroy($imageResource);

        if ($existingFile && file_exists($uploadDir . $existingFile)) {
            unlink($uploadDir . $existingFile);
        }

        return $targetName;
    }

    public function index()
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
        }
        $assetModel = new AssetModel();
        $data['assets'] = $assetModel->findAll();
        return view('assets/index', $data);
    }

    public function create()
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
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
            return redirect()->to(site_url('/'));
        }
        
        $rules = [
            'nama_barang' => 'required|min_length[3]',
            'keterangan' => 'required|min_length[3]|max_length[255]',
            'merk_barang' => 'permit_empty|max_length[255]',
            'tahun_pengadaan' => 'permit_empty|integer',
            'jenis_aset' => 'required|in_list[aset,non_aset]',
            'kondisi' => 'required|in_list[baik,rusak_ringan,rusak_berat]',
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,1024]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('barang/create'))->withInput()->with('error', 'Validasi gagal. Periksa kembali input form.');
        }

        $file = $this->request->getFile('foto');
        $fotoName = $this->processUploadedImageToWebp($file);
        
        $assetModel = new AssetModel();
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'keterangan' => $this->request->getPost('keterangan'),
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
        $qrCode = new QrCode(data: (string) $id);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);
        $fileName = 'qr_' . $id . '.png';
        $uploadDir = FCPATH . 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $result->saveToFile($uploadDir . $fileName);

        // Update asset with QR path
        $assetModel->update($id, ['qr_code' => $fileName]);

        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil ditambahkan');
    }

    public function show($id)
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
        }
        $assetModel = new AssetModel();
        $data['asset'] = $assetModel->find($id);
        if (!$data['asset']) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }
        return view('assets/show', $data);
    }

    public function edit($id)
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
        }
        $assetModel = new AssetModel();
        $data['asset'] = $assetModel->find($id);
        if (!$data['asset']) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }
        $tahunSekarang = date('Y');
        $data['years'] = range($tahunSekarang - 20, $tahunSekarang);
        $data['validation'] = \Config\Services::validation();
        return view('assets/edit', $data);
    }

    public function update($id)
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
        }
        
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);
        if (!$asset) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }

        $rules = [
            'nama_barang' => 'required|min_length[3]',
            'keterangan' => 'required|min_length[3]|max_length[255]',
            'merk_barang' => 'permit_empty|max_length[255]',
            'tahun_pengadaan' => 'permit_empty|integer',
            'jenis_aset' => 'required|in_list[aset,non_aset]',
            'kondisi' => 'required|in_list[baik,rusak_ringan,rusak_berat]',
            'status' => 'required|in_list[ada,dipinjam,hilang]',
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,1024]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('barang/' . $id . '/edit'))->withInput()->with('error', 'Validasi gagal. Periksa kembali input form.');
        }
        
        $file = $this->request->getFile('foto');
        $fotoName = $this->processUploadedImageToWebp($file, $asset['foto']);
        
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'keterangan' => $this->request->getPost('keterangan'),
            'merk_barang' => $this->request->getPost('merk_barang'),
            'tahun_pengadaan' => $this->request->getPost('tahun_pengadaan'),
            'foto' => $fotoName,
            'jenis_aset' => $this->request->getPost('jenis_aset'),
            'kondisi' => $this->request->getPost('kondisi'),
            'status' => $this->request->getPost('status'),
        ];
        $assetModel->update($id, $data);

        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
        }
        
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);
        if (!$asset) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
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

        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil dihapus');
    }
}
