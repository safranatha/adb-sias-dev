<?php

namespace Database\Factories;

use App\Models\Tender;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratPenawaranHarga>
 */
class SuratPenawaranHargaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'tender_id' => Tender::inRandomOrder()->first()?->id ?? Tender::factory(),
            'nama_sph' => 'Surat Penawaran Harga ' . fake()->words(1, true),
            'file_path_sph' => 'uploads/sph/' . fake()->slug() . '.pdf',
        ];
    }
}
