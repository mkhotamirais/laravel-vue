<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 1,
            'name' => 'ahmad',
            'email' => 'ahmad@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'remember_token' => null,
        ]);

        User::factory()->create([
            'id' => 2,
            'name' => 'abdul',
            'email' => 'abdul@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'remember_token' => null,
        ]);

        User::factory(4)->create();
        Listing::factory(50)->create();
    }
}
