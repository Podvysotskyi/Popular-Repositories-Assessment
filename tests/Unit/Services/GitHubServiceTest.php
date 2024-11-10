<?php

namespace Tests\Unit\Services;

use App\Services\GitHubService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GitHubServiceTest extends TestCase
{
    use WithFaker;

    private string $api_url = 'http://example.com';

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function test_it_can_search_repositories()
    {
        $responseData = [
            'items' => [
                [
                    'id' => 1,
                    'name' => $this->faker->unique()->userName,
                    'url' => $this->faker->url,
                    'created_at' => $this->faker->date,
                    'pushed_at' => $this->faker->date,
                    'description' => $this->faker->text,
                    'stargazers_count' => $this->faker->numberBetween(10, 100),
                    'owner' => [
                        'id' => 1,
                        'login' => $this->faker->unique()->userName,
                    ]
                ]
            ]
        ];

        Http::fake([
            "$this->api_url/search/repositories*" => Http::response($responseData),
        ]);

        $service = new GitHubService(['api_url' => $this->api_url]);
        $repositories = $service->searchRepositories('test');
        $this->assertCount(count($responseData), $repositories);

        foreach ($responseData['items'] as $index => $item) {
            $this->assertEquals($item['id'], $repositories[$index]->id);
            $this->assertEquals($item['name'], $repositories[$index]->name);
            $this->assertEquals($item['url'], $repositories[$index]->url);
            $this->assertEquals(Carbon::parse($item['created_at']), $repositories[$index]->created_at);
            $this->assertEquals(Carbon::parse($item['pushed_at']), $repositories[$index]->pushed_at);
            $this->assertEquals($item['description'], $repositories[$index]->description);
            $this->assertEquals($item['stargazers_count'], $repositories[$index]->stargazers_count);
            $this->assertEquals($item['owner']['id'], $repositories[$index]->owner->id);
            $this->assertEquals($item['owner']['login'], $repositories[$index]->owner->login);
        }
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function test_it_can_get_repository()
    {
        $testOwner = $this->faker->unique()->userName;
        $testRepository = $this->faker->unique()->userName;

        $responseData = [
            'id' => 1,
            'name' => $testRepository,
            'url' => $this->faker->url,
            'created_at' => $this->faker->date,
            'pushed_at' => $this->faker->date,
            'description' => $this->faker->text,
            'stargazers_count' => $this->faker->numberBetween(10, 100),
            'owner' => [
                'id' => 1,
                'login' => $testOwner,
            ]

        ];
        Http::fake([
            "$this->api_url/repos/$testOwner/$testRepository" => Http::response($responseData),
        ]);


        $service = new GitHubService(['api_url' => $this->api_url]);
        $repository = $service->getRepository($testOwner, $testRepository);

        $this->assertEquals($responseData['id'], $repository->id);
        $this->assertEquals($responseData['name'], $repository->name);
        $this->assertEquals($responseData['url'], $repository->url);
        $this->assertEquals(Carbon::parse($responseData['created_at']), $repository->created_at);
        $this->assertEquals(Carbon::parse($responseData['pushed_at']), $repository->pushed_at);
        $this->assertEquals($responseData['description'], $repository->description);
        $this->assertEquals($responseData['stargazers_count'], $repository->stargazers_count);
        $this->assertEquals($responseData['owner']['id'], $repository->owner->id);
        $this->assertEquals($responseData['owner']['login'], $repository->owner->login);
    }
}
