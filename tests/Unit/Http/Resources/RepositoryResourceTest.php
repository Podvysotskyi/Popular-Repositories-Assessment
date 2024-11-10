<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\RepositoryResource;
use App\Models\Repository;
use Tests\TestCase;

class RepositoryResourceTest extends TestCase
{
    public function test_it_can_retrieve_resource() {
        /** @var Repository $repository */
        $repository = Repository::factory()->make([
            'id' => $this->faker->uuid,
        ]);
        $repository->owner = Repository::factory()->make([
            'id' => $this->faker->uuid,
        ]);

        $resource = new RepositoryResource($repository);

        $this->assertEquals($resource->toArray(), [
            'id' => $repository->id,
            'import_id' => $repository->import_id,
            'name' => $repository->name,
            'stars' => $repository->stars_count,
            'url' => $repository->url,
            'description' => $repository->description,
            'owner' => $repository->owner->login,
            'created_at' => $repository->repository_created_at->format('Y-m-d H:i:s'),
            'pushed_at' => $repository->repository_pushed_at->format('Y-m-d H:i:s'),
        ]);
    }
}
