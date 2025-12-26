<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormTugas>
 */
class FormTugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::whereIn('id', [2, 4, 5])
                ->inRandomOrder()
                ->value('id'),

            'status' => fake()->boolean(),
            'due_date' => fake()->dateTimeBetween('now', '+60 days')->format('Y-m-d'),
            'jenis_permintaan' => fake()->randomElement(['Permintaan', 'Pengajuan']),
            'kegiatan' => fake()->sentence(),
            'keterangan' => fake()->sentence(),
            'file_path_form_tugas' => fake()->imageUrl(),
            'lingkup_kerja' => fake()->sentence(),
        ];
    }
}
