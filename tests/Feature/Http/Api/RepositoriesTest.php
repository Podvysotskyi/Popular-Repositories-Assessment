<?php

namespace Tests\Feature\Http\Api;

use App\Models\Repository;
use App\Services\RepositoryService;
use Mockery;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Feature\TestCase;

class RepositoriesTest extends TestCase
{
    public function test_it_can_update_repositories(): void
    {
        $this->instance(RepositoryService::class, Mockery::mock(RepositoryService::class, function ($mock) {
            $repositories = Repository::factory()
                ->count(3)
                ->forOwner()
                ->create();

            $mock->shouldReceive('updateRepositories')
                ->once()
                ->andReturn($repositories);
        }));

        $response = $this->post('/api/repositories');
        $response->assertStatus(HttpResponse::HTTP_OK);
        $this->assertCount(3, $response->json());
    }

    public function test_it_can_show_repository(): void
    {
        $repository = Repository::factory()
            ->forOwner()
            ->create();

        $response = $this->get("/api/repositories/$repository->id");
        $response->assertStatus(HttpResponse::HTTP_OK);
    }

    public function test_it_can_update_repository(): void
    {
        $repository = Repository::factory()
            ->forOwner()
            ->create();

        $this->instance(RepositoryService::class, Mockery::mock(RepositoryService::class, function ($mock) use ($repository) {
            $mock->shouldReceive('updateRepository')
                ->with($repository->id)
                ->once()
                ->andReturn($repository);
        }));

        $response = $this->post("/api/repositories/$repository->id");
        $response->assertStatus(HttpResponse::HTTP_OK);
    }
}
