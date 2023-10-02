<?php

namespace EZSCALE\Virtfusion\Dns;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;

class Dns extends Virtfusion
{
    /**
     * @param  int  $serviceId
     * @return Collection|null
     */
    public function service(int $serviceId): ?Collection
    {
        try {
            $response = $this->get("api/v1/dns/services/{$serviceId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No DNS service found for ID {$serviceId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve DNS service {$serviceId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for service {$serviceId}.", $e->getTrace());
            return null;
        }
    }
}
