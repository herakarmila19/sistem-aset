<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session('user_id')) {
            return redirect()->to('/');
        }
        return view('dashboard/index');
    }
}
