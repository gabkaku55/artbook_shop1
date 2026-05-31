<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UpdateAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'admin')->first();
        if ($user) {
            $user->email = 'yanapampukha2006@gmail.com';
            $user->password = Hash::make('qwerty1234');
            $user->save();
        } else {
            User::create([
                'name' => 'Admin',
                'email' => 'yanapampukha2006@gmail.com',
                'password' => Hash::make('qwerty1234'),
                'role' => 'admin',
            ]);
        }
    }
}
