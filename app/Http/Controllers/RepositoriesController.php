<?php

namespace App\Http\Controllers;

use App\Http\Resources\RepositoryCollectionResource;
use App\Http\Resources\RepositoryResource;
use App\Models\GitHub\Repository;
use App\Services\GitHub\RepositoryService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RepositoriesController extends Controller
{
    public function __construct(protected RepositoryService $repositoryService) {

    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function index(): InertiaResponse
    {
        $repositories = $this->repositoryService->getRepositories();

        if ($repositories->isEmpty()) {
            $repositories = $this->repositoryService->updateRepositories();
        }

        return Inertia::render('Repositories', [
            'repositories' => RepositoryCollectionResource::collection($repositories),
        ]);
    }

    public function show(Repository $repository): JsonResponse
    {
        return Response::json(new RepositoryResource($repository));
    }
}