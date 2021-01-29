<?php namespace App\Database\Seeds;

use App\Repositories\UserRepository;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        UserRepository::create([
                'name' => 'مدیر',
                'family' => 'کل',
            'email' => 'admin@admin.com',
            'password' => '123456',
            'role' => 'admin'
        ]);
    }
}
