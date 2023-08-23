<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'admin@admin.com'
        ],[
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@123'),
            'profile_img' => 'http://localhost/pdf-generator/public/assets/images/side-logo.png',
            'is_admin' => 1,
            "user_status" => 'approved'
        ]);
    }
}
