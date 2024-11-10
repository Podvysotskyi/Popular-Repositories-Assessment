<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepositoryCollectionResource;
use App\Services\RepositoryService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Inertia\Inertia;
use Inertia\Response;

class RepositoriesController extends Controller
{
    public function __construct(protected RepositoryService $repositoryService)
    {

    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function __invoke(): Response
    {
        $repositories = $this->repositoryService->getRepositories();

        if ($repositories->isEmpty()) {
            $repositories = $this->repositoryService->updateRepositories();
        }

        return Inertia::render('Repositories', [
            'repositories' => RepositoryCollectionResource::collection($repositories),
        ]);
    }
}
