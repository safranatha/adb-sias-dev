<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tender>
 */
class TenderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_tender' => strtoupper(
                fake()->randomElement([
                    'Pengadaan Jasa Konsultan',
                    'Pengadaan Sistem Informasi',
                    'Pekerjaan Renovasi Gedung',
                    'Pembangunan Infrastruktur IT',
                    'Pengembangan Aplikasi Mobile',
                ]) . ' ' . fake()->numerify('Tahun ####')
            ),
            'nama_klien' => fake()->name(),
            'status' => fake()->randomElement(['Gagal', 'Berhasil', 'Dalam Proses']),
            'file_pra_kualifikasi' => fake()->imageUrl(),
        ];
    }
}
