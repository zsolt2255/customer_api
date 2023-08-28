<?php

declare(strict_types=1);

namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

trait ClientGatewayTrait
{
    /**
     * @param string $uri
     * @param array $options
     * @return mixed|string
     * @throws GuzzleException
     */
    public function sendHttpGet(string $uri, array $options = []): mixed
    {
        try {
            $response = $this->httpClient->get($uri, $options);

            $responseData = json_decode($response->getBody()->getContents(), true);

            $this->checkAuthentication($responseData);

            return $responseData;
        } catch (AuthenticationException $exception) {
            throw new HttpResponseException(response()->json($responseData));
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param string $uri
     * @param array $options
     * @return JsonResponse|mixed|string
     * @throws GuzzleException
     */
    public function sendHttpPost(string $uri, array $options = []): mixed
    {
        try {
            $response = $this->httpClient->post($uri, $options);

            $responseData = json_decode($response->getBody()->getContents(), true);

            $this->checkAuthentication($responseData);

            if (isset($responseData['message'], $responseData['errors'])) {
                return response()->json($responseData);
            }

            return $responseData;
        } catch (AuthenticationException $exception) {
            throw new HttpResponseException(response()->json($responseData));
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param string $uri
     * @param array $options
     * @return mixed|string
     * @throws GuzzleException
     */
    public function sendHttpPatch(string $uri, array $options = []): mixed
    {
        try {
            $response = $this->httpClient->patch($uri, $options);

            $responseData = json_decode($response->getBody()->getContents(), true);

            $this->checkAuthentication($responseData);

            return $responseData;
        } catch (AuthenticationException $exception) {
            throw new HttpResponseException(response()->json($responseData));
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @throws AuthenticationException
     */
    private function checkAuthentication($responseData): void
    {
        if (is_array($responseData) && (isset($responseData['auth']) || isset($responseData['success'])) ) {
            throw new AuthenticationException('Unauthorized');
        }
    }
}
