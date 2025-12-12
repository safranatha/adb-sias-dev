<?php

namespace Database\Factories;

use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentApprovalWorkflow>
 */
class DocumentApprovalWorkflowFactory extends Factory
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
            'proposal_id' => Proposal::inRandomOrder()->first()?->id ?? Proposal::factory(),
            'level' => fake()->numberBetween(1, 3),
            'status' => fake()->boolean(),
            'keterangan' => fake()->sentence(),
            'pesan_revisi' => fake()->sentence(),
        ];
    }
}
