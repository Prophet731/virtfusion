<?php

namespace EZSCALE\Virtfusion\Media;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;

class Media extends Virtfusion
{
    /**
     * @param  int  $isoId
     * @return Collection|null
     */
    public function iso(int $isoId): ?Collection
    {
        try {
            $response = $this->get("api/v1/media/iso/{$isoId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No ISO found for ID {$isoId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve ISO {$isoId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for ISO {$isoId}.", $e->getTrace());
            return null;
        }
    }

    /**
     * @param  int  $packageId
     * @return Collection|null
     */
    public function osTemplatesByPackageId(int $packageId): ?Collection
    {
        try {
            $response = $this->get("api/v1/media/templates/fromServerPackageSpec/{$packageId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No templates found for package ID {$packageId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve templates for package ID {$packageId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for package ID {$packageId}.", $e->getTrace());
            return null;
        }
    }
}
