<?php

namespace Database\Factories;

use App\Models\shift;
use App\Models\bagian;
use App\Models\jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => fake()->nik(),
            'nama_pegawai' => fake()->name(),
            'alamat' => fake()->sentence(3),
            'gender' => fake()->numberBetween(0,3),
            'tgl_lahir' => fake()->date(),
            'jabatan_id' => jabatan::factory(),
            'bagian_id' => bagian::factory(),
            'shift_id' => shift::factory(),
            'foto' => null,
            'user_id' => null,
        ];
    }
}
