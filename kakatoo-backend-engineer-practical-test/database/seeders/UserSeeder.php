<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Board A',
            'email' => 'boarda@gmail.com',
            'username' => 'Board A',
            'password' => Hash::make('board123'),
            'profile_id' => 1,
        ]);
    }
}
