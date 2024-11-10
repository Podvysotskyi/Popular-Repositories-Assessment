<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\RepositoryCollectionResource;
use App\Models\Repository;
use Tests\TestCase;

class RepositoryCollectionResourceTest extends TestCase
{
    public function test_it_can_retrieve_resource() {
        /** @var Repository $repository */
        $repository = Repository::factory()->make([
            'id' => $this->faker->uuid,
        ]);
        $repository->owner = Repository::factory()->make([
            'id' => $this->faker->uuid,
        ]);

        $resource = new RepositoryCollectionResource($repository);

        $this->assertEquals($resource->toArray(), [
            'id' => $repository->id,
            'name' => "{$repository->owner->login}/$repository->name",
            'stars' => $repository->stars_count,
        ]);
    }
}
