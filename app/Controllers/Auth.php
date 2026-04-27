<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/login');
    }

    public function login()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $captcha = trim((string) ($this->request->getPost('captcha_confirm') ?? $this->request->getPost('captcha')));
        $expectedCaptcha = session('captcha');

        if (
            $expectedCaptcha === null
            || !is_numeric($captcha)
            || (int) $captcha !== (int) $expectedCaptcha
        ) {
            return redirect()->back()->with('error', 'Captcha salah');
        }

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('user_id', $user['id']);
            session()->set('username', $user['username']);
            session()->set('nama_user', $user['nama_user'] ?? 'Administrator');
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('/'))->with('success', 'Anda berhasil logout.');
    }

    public function captcha()
    {
        // Generate random 6-digit captcha code
        $captchaCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        session()->set('captcha', $captchaCode);
        
        // Set header untuk plain text response
        header('Content-Type: text/plain');
        return $captchaCode;
    }
}
