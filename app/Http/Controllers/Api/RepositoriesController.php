<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RepositoryCollectionResource;
use App\Http\Resources\RepositoryResource;
use App\Models\GitHub\Repository;
use App\Services\GitHub\RepositoryService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class RepositoriesController extends Controller
{
    public function __construct(protected RepositoryService $repositoryService)
    {
    }


    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function updateRepositories(): JsonResponse
    {
        $repositories = $this->repositoryService->updateRepositories();

        return Response::json(RepositoryCollectionResource::collection($repositories));
    }

    public function showRepository(Repository $repository): JsonResponse
    {
        return Response::json(new RepositoryResource($repository));
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function updateRepository(Repository $repository): JsonResponse
    {
        $repository = $this->repositoryService->updateRepository($repository->id);

        return Response::json(new RepositoryResource($repository));
    }
}
