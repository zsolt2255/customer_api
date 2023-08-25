<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserResourceCollection;
use App\Http\Services\DatabaseApi;
use App\Traits\JsonTrait;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use JsonTrait;

    /**
     * @param DatabaseApi $databaseApi
     */
    public function __construct(
        private readonly DatabaseApi $databaseApi
    ) {}

    /**
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function index(): JsonResponse
    {
        $users = $this->databaseApi->index();

        return (new UserResourceCollection($users))->response();
    }

    /**
     * @param string $userId
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function show(string $userId): JsonResponse
    {
        $user = $this->databaseApi->show($userId);

        return (new UserResource($user))->response();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function store(Request $request): JsonResponse
    {
        $data = $this->databaseApi->store($request->all());

        return $this->jsonCreated($data);
    }

    /**
     * @param string $userId
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     */
    public function update(string $userId, Request $request): JsonResponse
    {
        $data = $this->databaseApi->update($userId, $request->all());

        return $this->jsonUpdated($data);
    }
}
