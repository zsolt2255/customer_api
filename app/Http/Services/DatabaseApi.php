<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Services\Contracts\DatabaseApiInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class DatabaseApi implements DatabaseApiInterface
{
    /**
     * @param ClientGateway $clientGateway
     */
    public function __construct(
        private readonly ClientGateway $clientGateway
    ) {}

    /**
     * @return mixed|string
     * @throws GuzzleException
     */
    public function index(): mixed
    {
        return $this->clientGateway->index();
    }

    /**
     * @param string $userId
     * @return mixed|string
     * @throws GuzzleException
     */
    public function show(string $userId): mixed
    {
        return $this->clientGateway->show($userId);
    }

    /**
     * @param array $data
     * @return JsonResponse|mixed|string
     * @throws GuzzleException
     */
    public function store(array $data): mixed
    {
        return $this->clientGateway->store($data);
    }

    /**
     * @param string $userId
     * @param array $data
     * @return mixed|string
     * @throws GuzzleException
     */
    public function update(string $userId, array $data): mixed
    {
        return $this->clientGateway->update($userId, $data);
    }
}
