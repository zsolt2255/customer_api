<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait JsonTrait
{
    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    protected function json(array $data = [], int $status = 200, array $headers = []): JsonResponse
    {
        return response()->json(array_merge([
            'status' => 'success',
        ], [
            'data' => $data
        ]), $status, $headers);
    }

    /**
     * @param $data
     * @param int|null $id
     * @return JsonResponse
     */
    public function jsonCreated($data, int $id = null): JsonResponse
    {
        if ($data instanceof JsonResponse) {
            return $data;
        }

        if ($id) {
            $data['id'] = $id;
        }

        return $this->json($data, Response::HTTP_CREATED);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function jsonAccepted(array $data = []): JsonResponse
    {
        return $this->json($data, Response::HTTP_ACCEPTED);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function jsonUpdated($data): JsonResponse
    {
        if (is_array($data)) {
            return $this->json($data, Response::HTTP_BAD_REQUEST);
        }

        return $this->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function jsonOk(array $data = []): JsonResponse
    {
        return $this->json($data, Response::HTTP_OK);
    }
}
