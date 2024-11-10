<?php

namespace App\Services\GitHub;

use App\DataValueObjects\GitHub\RepositoryData;
use App\Models\GitHub\Repository;
use App\Models\GitHub\RepositoryOwner;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RepositoryService
{
    public function __construct(
        protected ApiService $apiService,
    )
    {
    }

    public function getRepositories(): Collection
    {
        return Repository::with(['owner'])
            ->orderBy('stars_count', 'desc')
            ->get();
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function updateRepositories(): Collection
    {
        // Request new repository list from GitHub API
        $repositoriesData = $this->apiService->searchRepositories('language:php');

        $repositories = collect();

        // DB transaction to update repository list
        DB::transaction(function () use ($repositoriesData, $repositories) {
            /** @var RepositoryData $repositoryData */
            foreach ($repositoriesData as $repositoryData) {

                $repositoryOwner = $this->updateOrCreateRepositoryOwner(
                    import_id: $repositoryData->owner->id,
                    login: $repositoryData->owner->login,
                );

                $repository = $this->updateOrCreateRepository(
                    owner: $repositoryOwner,
                    import_id: $repositoryData->id,
                    name: $repositoryData->name,
                    url: $repositoryData->url,
                    description: $repositoryData->description,
                    stars_count: $repositoryData->stargazers_count,
                    created_at: $repositoryData->created_at,
                    pushed_at: $repositoryData->pushed_at,
                );

                $repositories->add($repository);
            }

            // Delete existing repositories that are no longer in the list
            Repository::query()
                ->whereNotIn('id', $repositories->pluck('id'))
                ->delete();
        });

        return $repositories;
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function updateRepository(
        string $repositoryId,
    ): void
    {
        $repository = Repository::with(['owner'])
            ->findOrFail($repositoryId);

        // Request new repository details from GitHub API
        $repositoryData = $this->apiService->getRepository(
            owner: $repository->owner->login,
            name: $repository->name,
        );

        $repositoryOwner = $this->updateOrCreateRepositoryOwner(
            import_id: $repositoryData->owner->id,
            login: $repositoryData->owner->login,
        );

        $this->updateOrCreateRepository(
            owner: $repositoryOwner,
            import_id: $repositoryData->id,
            name: $repositoryData->name,
            url: $repositoryData->url,
            description: $repositoryData->description,
            stars_count: $repositoryData->stargazers_count,
            created_at: $repositoryData->created_at,
            pushed_at: $repositoryData->pushed_at,
        );
    }

    protected function updateOrCreateRepository(
        RepositoryOwner $owner,
        int             $import_id,
        string          $name,
        string          $url,
        ?string          $description,
        int             $stars_count,
        Carbon          $created_at,
        Carbon          $pushed_at,
    ): Repository
    {
        return Repository::query()->updateOrCreate([
            'import_id' => $import_id,
        ], [
            'owner_id' => $owner->id,
            'name' => $name,
            'url' => $url,
            'description' => $description,
            'stars_count' => $stars_count,
            'repository_created_at' => $created_at,
            'repository_pushed_at' => $pushed_at,
        ]);
    }

    protected function updateOrCreateRepositoryOwner(
        int    $import_id,
        string $login,
    ): RepositoryOwner
    {
        return RepositoryOwner::query()->updateOrCreate([
            'import_id' => $import_id
        ], [
            'login' => $login,
        ]);
    }
}
