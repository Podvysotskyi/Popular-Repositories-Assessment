<?php

namespace Tests\Feature\Services\GitHub;

use App\DataValueObjects\GitHub\RepositoryData;
use App\DataValueObjects\GitHub\RepositoryOwnerData;
use App\Models\GitHub\Repository;
use App\Models\GitHub\RepositoryOwner;
use App\Services\GitHub\ApiService;
use App\Services\GitHub\RepositoryService;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Mockery\MockInterface;
use Tests\Feature\TestCase;

class RepositoryServiceTest extends TestCase
{
    protected MockInterface|ApiService $apiService;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiService = $this->spy(ApiService::class);
    }

    /**
     * A basic test example.
     */
    public function test_it_can_get_repositories(): void
    {
        Repository::factory()
            ->count(3)
            ->forOwner()
            ->create();

        $service = new RepositoryService($this->apiService);
        $repositories = $service->getRepositories();

        $this->assertCount(3, $repositories);
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function test_it_can_update_repositories(): void
    {
        $repositoryData = new RepositoryData(
            id: $this->faker->numberBetween(1, 10),
            name: $this->faker->userName(),
            url: $this->faker->url(),
            created_at: Carbon::now(),
            pushed_at: Carbon::now(),
            description: $this->faker->text(),
            stargazers_count: $this->faker->numberBetween(10, 100),
            owner: new RepositoryOwnerData(
                id: $this->faker->numberBetween(1, 10),
                login: $this->faker->userName(),
            )
        );
        $this->apiService->shouldReceive('searchRepositories')
            ->with('language:php')
            ->andReturn([$repositoryData]);

        $service = new RepositoryService($this->apiService);
        $service->updateRepositories();

        $this->assertDatabaseCount(Repository::class, 1);
        $this->assertDatabaseHas(Repository::class, [
            'import_id' => $repositoryData->id,
            'name' => $repositoryData->name,
            'url' => $repositoryData->url,
            'description' => $repositoryData->description,
            'stars_count' => $repositoryData->stargazers_count,
        ]);

        $this->assertDatabaseCount(RepositoryOwner::class, 1);
        $this->assertDatabaseHas(RepositoryOwner::class, [
            'import_id' => $repositoryData->owner->id,
            'login' => $repositoryData->owner->login,
        ]);
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function test_it_can_delete_old_repositories(): void
    {
        Repository::factory()
            ->forOwner()
            ->create();

        $this->apiService->shouldReceive('searchRepositories')
            ->with('language:php')
            ->andReturn([]);

        $service = new RepositoryService($this->apiService);
        $service->updateRepositories();

        $this->assertDatabaseEmpty(Repository::class);
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function test_it_can_update_repository(): void
    {
        /** @var Repository $repository */
        $repository = Repository::factory()
            ->forOwner()
            ->create();

        $repositoryData = new RepositoryData(
            id: $repository->import_id,
            name: $this->faker->userName(),
            url: $this->faker->url(),
            created_at: Carbon::now(),
            pushed_at: Carbon::now(),
            description: $this->faker->text(),
            stargazers_count: $this->faker->numberBetween(10, 100),
            owner: new RepositoryOwnerData(
                id: $repository->owner->import_id,
                login: $this->faker->userName(),
            )
        );
        $this->apiService->shouldReceive('getRepository')
            ->andReturn($repositoryData);

        $service = new RepositoryService($this->apiService);
        $service->updateRepository($repository->id);

        $this->assertDatabaseCount(Repository::class, 1);
        $this->assertDatabaseHas(Repository::class, [
            'id' => $repository->id,
            'import_id' => $repositoryData->id,
            'owner_id' => $repository->owner_id,
            'name' => $repositoryData->name,
            'url' => $repositoryData->url,
            'description' => $repositoryData->description,
            'stars_count' => $repositoryData->stargazers_count,
        ]);

        $this->assertDatabaseCount(RepositoryOwner::class, 1);
        $this->assertDatabaseHas(RepositoryOwner::class, [
            'id' => $repository->owner_id,
            'import_id' => $repositoryData->owner->id,
            'login' => $repositoryData->owner->login,
        ]);
    }
}
