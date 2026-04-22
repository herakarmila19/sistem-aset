<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function index()
    {
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
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function captcha()
    {
        $code = (string) random_int(100000, 999999);

        session()->set('captcha', $code);
        return $code;
    }
}
