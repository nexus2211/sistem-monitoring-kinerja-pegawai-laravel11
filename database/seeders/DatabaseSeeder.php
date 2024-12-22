<?php

namespace Database\Seeders;

use App\Models\bagian;
use App\Models\jabatan;
use App\Models\pegawai;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('123'),
            'type' => '2',
        ]);

        // Jabatan::factory(5)->create();
        // Bagian::factory(5)->create();

        Pegawai::factory(5)->create();
    }
}
