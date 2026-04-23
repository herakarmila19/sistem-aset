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

        $existing = $this->db->table('users')->where('username', $data['username'])->get()->getRowArray();
        if ($existing) {
            $this->db->table('users')->where('id', $existing['id'])->update(['password' => $data['password']]);
            return;
        }

        $this->db->table('users')->insert($data);
    }
}
