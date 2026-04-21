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
        $operations = ['+', '-', '*', '/'];
        $operation = $operations[array_rand($operations)];
        $num1 = random_int(1, 20);
        $num2 = random_int(1, 20);

        switch ($operation) {
            case '-':
                if ($num1 < $num2) {
                    [$num1, $num2] = [$num2, $num1];
                }
                $answer = $num1 - $num2;
                $question = "$num1 - $num2 = ?";
                break;
            case '*':
                $answer = $num1 * $num2;
                $question = "$num1 × $num2 = ?";
                break;
            case '/':
                $num2 = random_int(1, 10);
                $answer = random_int(1, 10);
                $num1 = $num2 * $answer;
                $question = "$num1 ÷ $num2 = ?";
                break;
            default:
                $answer = $num1 + $num2;
                $question = "$num1 + $num2 = ?";
                break;
        }

        session()->set('captcha', $answer);
        return $question;
    }
}
