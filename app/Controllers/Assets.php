<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Assets extends BaseController
{
    private AssetModel $assetModel;

    public function __construct()
    {
        $this->assetModel = new AssetModel();
    }

    private function ensureSession()
    {
        if (!session('user_id')) {
            return redirect()->to(site_url('/'));
        }

        return null;
    }

    private function createQrCode(int $assetId): string
    {
        $qrUrl = site_url('barang/' . $assetId);
        $writer = new PngWriter();
        $result = $writer->write(new QrCode(data: $qrUrl));

        $uploadDir = FCPATH . 'uploads/qrcode/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = 'barang_' . $assetId . '_' . date('YmdHis') . '.png';
        $result->saveToFile($uploadDir . $fileName);

        return $fileName;
    }

    private function processUploadedImageToWebp(?\CodeIgniter\HTTP\Files\UploadedFile $file, ?string $existingFile = null): ?string
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
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
        imagewebp($imageResource, $targetPath, 85);
        imagedestroy($imageResource);

        if ($existingFile && file_exists($uploadDir . $existingFile)) {
            unlink($uploadDir . $existingFile);
        }

        return $targetName;
    }

    public function index()
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        return view('assets/index', [
            'title' => 'Data Barang',
            'assets' => $this->assetModel->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        return view('assets/create', [
            'title' => 'Tambah Barang',
            'years' => range(date('Y') - 20, date('Y')),
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
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
            return redirect()->to(site_url('barang/create'))->withInput()->with('validation', $this->validator);
        }

        $assetId = $this->assetModel->insert([
            'nama_barang' => $this->request->getPost('nama_barang'),
            'keterangan' => $this->request->getPost('keterangan'),
            'merk_barang' => $this->request->getPost('merk_barang'),
            'tahun_pengadaan' => $this->request->getPost('tahun_pengadaan') ?: null,
            'foto' => $this->processUploadedImageToWebp($this->request->getFile('foto')),
            'jenis_aset' => $this->request->getPost('jenis_aset'),
            'kondisi' => $this->request->getPost('kondisi'),
            'status' => 'tersedia',
        ]);

        $fileName = $this->createQrCode((int) $assetId);
        $this->assetModel->update($assetId, ['qr_code' => $fileName]);

        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil ditambahkan dan QR Code berhasil digenerate.');
    }

    public function show($id)
    {
        $asset = $this->assetModel->find($id);
        if (!$asset) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }

        return view('assets/show', [
            'asset' => $asset,
            'title' => 'Detail Barang',
        ]);
    }

    public function edit($id)
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        $asset = $this->assetModel->find($id);
        if (!$asset) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }

        return view('assets/edit', [
            'title' => 'Edit Barang',
            'asset' => $asset,
            'years' => range(date('Y') - 20, date('Y')),
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        $asset = $this->assetModel->find($id);
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
            'status' => 'required|in_list[tersedia,dipinjam]',
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,1024]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('barang/' . $id . '/edit'))->withInput()->with('validation', $this->validator);
        }

        $this->assetModel->update($id, [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'keterangan' => $this->request->getPost('keterangan'),
            'merk_barang' => $this->request->getPost('merk_barang'),
            'tahun_pengadaan' => $this->request->getPost('tahun_pengadaan') ?: null,
            'foto' => $this->processUploadedImageToWebp($this->request->getFile('foto'), $asset['foto']),
            'jenis_aset' => $this->request->getPost('jenis_aset'),
            'kondisi' => $this->request->getPost('kondisi'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        $asset = $this->assetModel->find($id);
        if (!$asset) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }

        if (!empty($asset['foto']) && file_exists(FCPATH . 'uploads/' . $asset['foto'])) {
            unlink(FCPATH . 'uploads/' . $asset['foto']);
        }

        if (!empty($asset['qr_code']) && file_exists(FCPATH . 'uploads/qrcode/' . $asset['qr_code'])) {
            unlink(FCPATH . 'uploads/qrcode/' . $asset['qr_code']);
        }

        $this->assetModel->delete($id);

        return redirect()->to(site_url('barang'))->with('success', 'Barang berhasil dihapus.');
    }
}
