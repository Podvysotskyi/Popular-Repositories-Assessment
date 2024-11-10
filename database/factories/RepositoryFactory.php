<?php

namespace Database\Factories;

use App\Models\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Repository>
 */
class RepositoryFactory extends Factory
{
    protected $model = Repository::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => $this->faker->uuid(),
            'import_id' => $this->faker->unique()->numberBetween(1, 100),
            'name' => $this->faker->userName(),
            'url' => $this->faker->url(),
            'description' => $this->faker->text(),
            'stars_count' => $this->faker->numberBetween(0, 100),
            'repository_created_at' => Carbon::now(),
            'repository_pushed_at' => Carbon::now(),
        ];
    }
}
