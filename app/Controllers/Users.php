<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    private function ensureSession()
    {
        if (!session('user_id')) {
            return redirect()->to(base_url('/'));
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        return view('users/index', [
            'title' => 'User Management',
            'users' => $this->userModel->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        return view('users/create', [
            'title' => 'Tambah User',
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function store()
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'nama_user' => 'required|min_length[3]|max_length[150]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('users/create'))->withInput()->with('validation', $this->validator);
        }

        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'nama_user' => $this->request->getPost('nama_user'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to(base_url('users'))->with('success', 'User admin berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('users'))->with('error', 'User tidak ditemukan.');
        }

        return view('users/edit', [
            'title' => 'Edit User',
            'user' => $user,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function update(int $id)
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('users'))->with('error', 'User tidak ditemukan.');
        }

        $usernameRule = 'required|min_length[3]|max_length[100]';
        if ($this->request->getPost('username') !== $user['username']) {
            $usernameRule .= '|is_unique[users.username]';
        }

        $rules = [
            'username' => $usernameRule,
            'nama_user' => 'required|min_length[3]|max_length[150]',
            'password' => 'permit_empty|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('users/' . $id . '/edit'))->withInput()->with('validation', $this->validator);
        }

        $payload = [
            'username' => $this->request->getPost('username'),
            'nama_user' => $this->request->getPost('nama_user'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $payload['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $payload);

        if ((int) session('user_id') === $id) {
            session()->set('username', $payload['username']);
            session()->set('nama_user', $payload['nama_user']);
        }

        return redirect()->to(base_url('users'))->with('success', 'User admin berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        if ($redirect = $this->ensureSession()) {
            return $redirect;
        }

        if ((int) session('user_id') === $id) {
            return redirect()->to(base_url('users'))->with('error', 'Akun yang sedang dipakai login tidak bisa dihapus.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to(base_url('users'))->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);

        return redirect()->to(base_url('users'))->with('success', 'User admin berhasil dihapus.');
    }
}
