<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Reynier',
                'last_name' => 'Sayu',
                'age' => '37',
                'sex' => 'M',
                'email' => 'rsayu@nauta.cu',
                'nacionalidad' => 'CUBA',
                'password' => Hash::make('password')    
            ],
        ]);
    }
}
