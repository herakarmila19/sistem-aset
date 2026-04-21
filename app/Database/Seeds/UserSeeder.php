<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username' => '@Adminaset2026',
            'password' => password_hash('@Aset2026', PASSWORD_DEFAULT),
        ];

        $this->db->table('users')->insert($data);
    }
}
