<?php

namespace EZSCALE\Virtfusion\Queue;

use EZSCALE\Virtfusion\Virtfusion;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use JsonException;

class Queue extends Virtfusion
{
    public function retrieve(int $queueId): ?\Illuminate\Support\Collection
    {
        try {
            $response = $this->get("api/v1/queue/{$queueId}");
            return collect($response->get('data'));
        } catch (ClientException $e) {
            Log::error("No queue found for ID {$queueId}.", $e->getTrace());
            return null;
        } catch (GuzzleException $e) {
            Log::error("Failed to retrieve queue {$queueId}.", $e->getTrace());
            return null;
        } catch (JsonException $e) {
            Log::error("Failed to decode JSON response for queue {$queueId}.", $e->getTrace());
            return null;
        }
    }
}
