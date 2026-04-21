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
        $captcha = trim((string) $this->request->getPost('captcha'));
        $expectedCaptcha = (string) session('captcha');

        if (
            $expectedCaptcha === ''
            || !ctype_digit($captcha)
            || !hash_equals($expectedCaptcha, $captcha)
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
        $answer = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        session()->set('captcha', $answer);
        return $answer;
    }
}
