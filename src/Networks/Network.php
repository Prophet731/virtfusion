<?php

namespace EZSCALE\Virtfusion\Networks;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;

class Network extends Virtfusion
{
    /**
     * @param  int  $networkId
     * @return Collection|null
     */
    public function retrieve(int $networkId): ?Collection
    {
        try {
            $response = $this->get("api/v1/connectivity/ipblocks/{$networkId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No network found for ID {$networkId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve network {$networkId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for network {$networkId}.", $e->getTrace());
            return null;
        }
    }
}
