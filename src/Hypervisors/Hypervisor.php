<?php

namespace EZSCALE\Virtfusion\Hypervisors;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;

class Hypervisor extends Virtfusion
{
    /**
     * @param  int  $hypervisorId
     * @return Collection|null
     */
    public function retrieve(int $hypervisorId): ?\Illuminate\Support\Collection
    {
        try {
            $response = $this->get("api/v1/compute/hypervisors/{$hypervisorId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No hypervisor found for ID {$hypervisorId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve hypervisor {$hypervisorId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for hypervisor {$hypervisorId}.", $e->getTrace());
            return null;
        }
    }
}
