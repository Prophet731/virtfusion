<?php

namespace EZSCALE\Virtfusion\Backups;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;

class Backup extends Virtfusion
{
    /**
     * Get all backups for a server and return them as a collection.
     * If no backups are found, return null.
     *
     * @param  int  $serverId
     * @return Collection|null
     */
    public function retrieve(int $serverId): ?Collection
    {
        try {
            $response = $this->get("api/v1/backups/server/{$serverId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No backups found for server {$serverId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve backups for server {$serverId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for server {$serverId}.", $e->getTrace());
            return null;
        }
    }
}
