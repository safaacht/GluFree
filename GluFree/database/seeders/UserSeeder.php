<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::insert([
            'name'=>'Safaa',
            'email'=>'chtaouisafaa@gmail.com',
            'password'=>Hash::make('chtaouisafaa@gmail.com'),
            'role'=>'admin'
        ]);
    }
}
