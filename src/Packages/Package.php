<?php

namespace EZSCALE\Virtfusion\Packages;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;

class Package extends Virtfusion
{
    /**
     * @param  int  $packageId
     * @return Collection|null
     */
    public function retrieve(int $packageId): ?Collection
    {
        try {
            $response = $this->get("api/v1/packages/{$packageId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No package found for ID {$packageId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve package {$packageId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for package {$packageId}.", $e->getTrace());
            return null;
        }
    }

    /**
     * @return Collection|null
     */
    public function all(): ?Collection
    {
        try {
            $response = $this->get("api/v1/packages");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No packages found.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve packages.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for packages.", $e->getTrace());
            return null;
        }
    }
}
