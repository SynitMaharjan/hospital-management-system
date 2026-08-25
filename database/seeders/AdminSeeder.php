<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        user::create([
            'name' => 'Admin User',
            'username' => 'adminuser',
            'employee_id' => 'EMP001',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
        user::create([
            'name' => 'Doctor User',
            'username' => 'doctoruser',
            'employee_id' => 'EMP002',
            'email' => 'doctor@example.com',
            'password' => bcrypt('doctor123'),
            'role' => 'doctor',
        ]);
        user::create([
            'name' => 'Nurse User',
            'username' => 'nurseuser',
            'employee_id' => 'EMP003',
            'email' => 'nurse@example.com',
            'password' => bcrypt('nurse123'),
            'role' => 'nurse',
        ]);
    }
}
