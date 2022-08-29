<?php

namespace yzh52521\GeoIp\services;

use Exception;
use yzh52521\GeoIp\support\HttpClient;

class IPGeoLocation extends AbstractService
{
    /**
     * Http client instance.
     *
     * @var HttpClient
     */
    protected $client;

    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot()
    {
        $base = [
            'base_uri' => 'https://api.ipgeolocation.io/',
        ];

        if ($this->config('key')) {
            $base['base_uri'] = "{$base['base_uri']}ipgeo?apiKey=" . $this->config('key');
        }

        $this->client = new HttpClient($base);
    }

    /**
     * {@inheritdoc}
     */

    public function locate($ip)
    {
        // Get data from client
        $data = $this->client->get('&ip=' . $ip);

        // Verify server response
        if ($this->client->getErrors() !== null) {
            throw new Exception('Request failed (' . $this->client->getErrors() . ')');
        }

        // Parse body content
        $json = json_decode($data[0], true);

        return $this->hydrate($json);
    }
}