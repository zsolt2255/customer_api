<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        private readonly UserService $userService,
    ) {}

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->userService->index();
    }

    /**
     * @param string $user
     * @return Model|Collection|Builder|array|null
     */
    public function show(string $user): Model|Collection|Builder|array|null
    {
        return $this->userService->show($user);
    }

    /**
     * @param StoreUserRequest $request
     * @return array
     */
    public function store(StoreUserRequest $request): array
    {
        return $this->userService->store($request);
    }

    /**
     * @param string $user
     * @param UpdateUserRequest $request
     * @return bool|int
     */
    public function update(string $user, UpdateUserRequest $request): bool|int
    {
        return $this->userService->update($user, $request);
    }
}
