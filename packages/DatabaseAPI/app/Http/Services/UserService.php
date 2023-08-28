<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\Eloquent\Contracts\AddressRepositoryInterface;
use App\Repositories\Eloquent\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param AddressRepositoryInterface $addressRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly AddressRepositoryInterface $addressRepository
    ) {}

    /**
     * @param StoreUserRequest $request
     * @return array
     */
    public function store(StoreUserRequest $request): array
    {
        $data = $request->all();
        $firstElement = Arr::first($data);
        $response = [];

        if (is_array($firstElement)) {
            foreach ($data as $item) {
                $user = $this->saveUser($item);

                $this->attachAddresses($item['addresses'], $user);

                $response[] = $user;
            }
        } else {
            $user = $this->saveUser($data);

            $this->attachAddresses($data['addresses'], $user);

            $response[] = $user;
        }

        return $response;
    }

    /**
     * @param string $userId
     * @param UpdateUserRequest $request
     * @return bool|int
     */
    public function update(string $userId, UpdateUserRequest $request): bool|int
    {
        $data = $request->all();

        $user = $this->userRepository->whereId($userId)->first();

        if ($user) {
            return $user->update($data);
        }

        return 0;
    }

    /**
     * @param iterable $addresses
     * @param User $user
     * @return void
     */
    private function attachAddresses(iterable $addresses, User $user): void
    {
        foreach ($addresses as $address) {
            $addressModel = $this->addressRepository->create($address);

            $user->addresses()->attach($addressModel->id);
        }
    }

    /**
     * @param array $data
     * @return Model
     */
    private function saveUser(array $data): Model
    {
        $data['password'] = Hash::make($data['password'], [
            'rounds' => 12,
        ]);

        return $this->userRepository->create($data);
    }

    public function index(): Collection|array
    {
        return $this->userRepository->with('addresses')->get();
    }

    /**
     * @param string $userId
     * @return Model|Collection|Builder|array|null
     */
    public function show(string $userId): Model|Collection|Builder|array|null
    {
        return $this->userRepository->with('addresses')->find($userId);
    }
}
