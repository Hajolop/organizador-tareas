<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $usuarios = [
            ['name' => 'David', 'email' => 'admin@example.com', 'administrator' => 1],
            ['name' => 'Miguel', 'email' => 'migue@example.com', 'administrator' => 0],
        ];

        foreach ($usuarios as $usuario) {
            $existe = $this->db->table('users')->where('email', $usuario['email'])->countAllResults();

            if ($existe === 0) {
                $this->db->table('users')->insert([
                    'name'          => $usuario['name'],
                    'email'         => $usuario['email'],
                    'password'      => password_hash('Demo12345', PASSWORD_DEFAULT),
                    'active'        => 1,
                    'administrator' => $usuario['administrator'],
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
