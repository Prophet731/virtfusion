<?php

namespace EZSCALE\Virtfusion\SSH;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use JsonException;

class SSH extends Virtfusion
{
    public function add(int $userId, string $name, string $publicKey): ?\Illuminate\Support\Collection
    {
        try {
            $response = $this->post("api/v1/ssh_keys", [
                'userId' => $userId,
                'name' => $name,
                'publicKey' => $publicKey,
            ]);
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("Failed to add SSH key for user {$userId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to add SSH key for user {$userId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response.", $e->getTrace());
            return null;
        }
    }

    public function remove(int $keyId): bool
    {
        return $this->delete("api/v1/ssh_keys/{$keyId}");
    }

    public function retrieveAllUserKeys (int $userId): ?\Illuminate\Support\Collection
    {
        try {
            $response = $this->get("api/v1/ssh_keys/user/{$userId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("Failed to retrieve SSH keys for user {$userId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve SSH keys for user {$userId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response.", $e->getTrace());
            return null;
        }
    }

    public function retrieve(int $keyId): ?\Illuminate\Support\Collection
    {
        try {
            $response = $this->get("api/v1/ssh_keys/{$keyId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("Failed to retrieve SSH key {$keyId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve SSH key {$keyId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response.", $e->getTrace());
            return null;
        }
    }
}
