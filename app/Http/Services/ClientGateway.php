<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Traits\ClientGatewayTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;

class ClientGateway
{
    use ClientGatewayTrait;

    /**
     * @var Client
     */
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => 'http://database_api:9000',
            'timeout'  => 10,
            'http_errors' => false,
        ]);
    }

    /**
     * @return mixed|string
     * @throws GuzzleException
     */
    public function index(): mixed
    {
        return $this->sendHttpGet('/api/users', [
            'headers' => request()->headers->all()
        ]);
    }

    /**
     * @param string $userId
     * @return mixed|string
     * @throws GuzzleException
     */
    public function show(string $userId): mixed
    {
        return $this->sendHttpGet('/api/users/' . $userId, [
            'headers' => request()->headers->all()
        ]);
    }

    /**
     * @param array $data
     * @return JsonResponse|mixed|string
     * @throws GuzzleException
     */
    public function store(array $data): mixed
    {
        return $this->sendHttpPost('/api/users', [
            'headers' => [
                    'Content-Type' => 'application/json'
                ] + request()->headers->all(),
            'body' => json_encode($data),
        ]);
    }

    /**
     * @param string $userId
     * @param array $data
     * @return mixed|string
     * @throws GuzzleException
     */
    public function update(string $userId, array $data): mixed
    {
        return $this->sendHttpPatch('/api/users/' . $userId, [
            'headers' => [
                'Content-Type' => 'application/json'
            ] + request()->headers->all(),
            'body' => json_encode($data),
        ]);
    }
}
