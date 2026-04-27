<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AssetModel;
use App\Models\PeminjamanModel;

class Peminjaman extends BaseController
{
    private AssetModel $assetModel;
    private PeminjamanModel $peminjamanModel;

    public function __construct()
    {
        $this->assetModel = new AssetModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    public function pinjam(int $id)
    {
        $asset = $this->assetModel->find($id);
        if (!$asset) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }

        $rules = [
            'nama_peminjam' => 'required|min_length[3]|max_length[255]',
            'keperluan' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('barang/' . $id))->withInput()->with('validation', $this->validator);
        }

        if ($asset['status'] === 'dipinjam') {
            return redirect()->to(site_url('barang/' . $id))->with('error', 'Barang sedang dipinjam dan belum dapat dipinjam ulang.');
        }

        $this->peminjamanModel->insert([
            'barang_id' => $id,
            'nama_peminjam' => $this->request->getPost('nama_peminjam'),
            'keperluan' => $this->request->getPost('keperluan'),
            'tanggal_pinjam' => date('Y-m-d H:i:s'),
        ]);

        $this->assetModel->update($id, ['status' => 'dipinjam']);

        return redirect()->to(site_url('barang/' . $id))->with('success', 'Peminjaman berhasil disimpan.');
    }

    public function kembalikan(int $id)
    {
        $asset = $this->assetModel->find($id);
        if (!$asset) {
            return redirect()->to(site_url('barang'))->with('error', 'Data barang tidak ditemukan.');
        }

        $peminjaman = $this->peminjamanModel
            ->where('barang_id', $id)
            ->where('tanggal_kembali', null)
            ->orderBy('id', 'DESC')
            ->first();

        if (!$peminjaman) {
            return redirect()->to(site_url('barang/' . $id))->with('error', 'Data peminjaman aktif tidak ditemukan.');
        }

        $rules = [
            'tanggal_kembali' => 'required|valid_date[Y-m-d\TH:i]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(site_url('barang/' . $id))->withInput()->with('validation', $this->validator);
        }

        $tanggalKembali = $this->request->getPost('tanggal_kembali');

        $this->peminjamanModel->update($peminjaman['id'], [
            'tanggal_kembali' => date('Y-m-d H:i:s', strtotime($tanggalKembali)),
            'foto_pengembalian' => null,
        ]);

        $this->assetModel->update($id, ['status' => 'tersedia']);

        return redirect()->to(site_url('barang/' . $id))->with('success', 'Barang berhasil dikembalikan.');
    }

    public function history()
    {
        $history = $this->peminjamanModel
            ->select('peminjaman.*, assets.nama_barang')
            ->join('assets', 'assets.id = peminjaman.barang_id')
            ->orderBy('peminjaman.id', 'DESC')
            ->findAll();

        return view('history/index', [
            'title' => 'History',
            'history' => $history,
        ]);
    }
}
