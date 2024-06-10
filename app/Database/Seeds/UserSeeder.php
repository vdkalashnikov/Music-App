<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = array(
            'name' => 'Mike',
            'email' => 'mike@gmail.com',
            'username' => 'mikemike',
            'password' => password_hash('mike1234', PASSWORD_BCRYPT),
        );

        $this->db->table('user')->insert($data);
    }
}
