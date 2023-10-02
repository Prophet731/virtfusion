<?php

namespace EZSCALE\Virtfusion;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Support\Collection;
use JsonException;

class Virtfusion
{
    /**
     * @var Client $client
     */
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('virtfusion.api_base_url'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('virtfusion.api_key'),
            ],
        ]);
    }

    /**
     * @return Backups\Backup
     */
    public function backups(): Backups\Backup
    {
        return new Backups\Backup();
    }

    public function dns(): Dns\Dns
    {
        return new Dns\Dns();
    }

    public function hypervisors(): Hypervisors\Hypervisor
    {
        return new Hypervisors\Hypervisor();
    }

    /**
     * @param  string  $endpoint
     * @return Collection
     * @throws GuzzleException
     * @throws JsonException
     */
    public function get(string $endpoint): Collection
    {
        $request = $this->client->get($endpoint)->getBody()->getContents();
        return collect(json_decode($request, true, 512, JSON_THROW_ON_ERROR));
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function post(string $endpoint, array $data): Collection
    {
        $request = $this->client->post($endpoint, [
            'json' => $data,
        ])->getBody()->getContents();
        return collect(json_decode($request, true, 512, JSON_THROW_ON_ERROR));
    }

    public function delete(string $endpoint): bool
    {
        try {
            $this->client->delete($endpoint);
            return true;
        } catch (GuzzleException) {
            return false;
        }
    }
}
