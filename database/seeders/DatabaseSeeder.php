<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@mail.com')->exists()) {
            User::factory()->create([
                'name' => 'Administrator',
                'email' => 'admin@mail.com',
            ]);
        }
        $this->call([
            PekerjaanSeeder::class,
            PegawaiSeeder::class,
        ]);
    }
}