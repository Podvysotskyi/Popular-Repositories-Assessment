<?php

namespace Database\Factories\GitHub;

use App\Models\GitHub\RepositoryOwner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RepositoryOwner>
 */
class RepositoryOwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'import_id' => $this->faker->unique()->numberBetween(1, 100),
            'login' => $this->faker->userName(),
        ];
    }
}
