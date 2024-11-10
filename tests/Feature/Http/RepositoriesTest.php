<?php

namespace Tests\Feature\Http;

use App\Models\GitHub\Repository;
use App\Services\GitHub\RepositoryService;
use Inertia\Testing\AssertableInertia;
use Mockery;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Feature\TestCase;

class RepositoriesTest extends TestCase
{
    public function test_it_can_return_repositories(): void
    {
        $this->instance(RepositoryService::class, Mockery::mock(RepositoryService::class, function ($mock) {
            $repositories = Repository::factory()
                ->count(3)
                ->forOwner()
                ->create();

            $mock->shouldReceive('getRepositories')
                ->once()
                ->andReturn($repositories);
        }));

        $response = $this->get('/');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Repositories')
                ->has('repositories', 3);
        });
    }

    public function test_it_can_update_repositories(): void
    {
        $this->instance(RepositoryService::class, Mockery::mock(RepositoryService::class, function ($mock) {
            $repositories = Repository::factory()
                ->count(3)
                ->forOwner()
                ->create();

            $mock->shouldReceive('getRepositories')
                ->once()
                ->andReturn(collect());

            $mock->shouldReceive('updateRepositories')
                ->once()
                ->andReturn($repositories);
        }));

        $response = $this->get('/');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Repositories')
                ->has('repositories', 3);
        });
    }
}
