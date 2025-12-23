<?php

namespace Database\Factories;

use App\Models\FormTugas;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposisi>
 */
class DisposisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'form_tugas_id' => FormTugas::inRandomOrder()->first()?->id ?? FormTugas::factory(),
            'penerima_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'waktu_disposisi_dibaca' => fake()->dateTimeBetween('now', '+60 days')->format('Y-m-d H:i:s'),
        ];
    }
}
