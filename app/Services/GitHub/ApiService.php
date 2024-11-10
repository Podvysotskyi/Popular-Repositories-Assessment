<?php

namespace App\Services\GitHub;

use App\DataValueObjects\GitHub\RepositoryData;
use App\DataValueObjects\GitHub\RepositoryOwnerData;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected PendingRequest $http;

    public function __construct(
        array $config,
    )
    {
        $this->http = Http::baseUrl($config['api_url']);
    }

    /**
     * @throws ConnectionException
     * @throws RequestException
     */
    public function searchRepositories(
        string $q,
        string $sort = 'stars',
        string $order = 'desc',
        int    $per_page = 100,
    ): array
    {
        $response = $this->http
            ->withHeaders([
                'X-GitHub-Api-Version' => '2022-11-28'
            ])->get('search/repositories', [
                'q' => $q,
                'sort' => $sort,
                'order' => $order,
                'per_page' => $per_page,
            ])->throw();

        return array_map(function (array $item) {
            return new RepositoryData(
                id: $item['id'],
                name: $item['name'],
                url: $item['url'],
                created_at: Carbon::parse($item['created_at']),
                pushed_at: Carbon::parse($item['pushed_at']),
                description: $item['description'],
                stargazers_count: $item['stargazers_count'],
                owner: new RepositoryOwnerData(
                    id: $item['owner']['id'],
                    login: $item['owner']['login'],
                ),
            );
        }, $response->json('items'));
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getRepository(
        string $owner,
        string $name,
    ): RepositoryData
    {
        $response = $this->http
            ->withHeaders([
                'X-GitHub-Api-Version' => '2022-11-28'
            ])->get("/repos/$owner/$name")
            ->throw();

        $data = $response->json();

        return new RepositoryData(
            id: $data['id'],
            name: $data['name'],
            url: $data['url'],
            created_at: Carbon::parse($data['created_at']),
            pushed_at: Carbon::parse($data['pushed_at']),
            description: $data['description'],
            stargazers_count: $data['stargazers_count'],
            owner: new RepositoryOwnerData(
                id: $data['owner']['id'],
                login: $data['owner']['login'],
            ),
        );
    }
}
