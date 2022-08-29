<?php

namespace yzh52521\GeoIp\services;

use yzh52521\GeoIP\Location;
use think\helper\Arr;
use yzh52521\GeoIP\Contracts\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    /**
     * Driver config
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new service instance.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;

        $this->boot();
    }

    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate(array $attributes = [])
    {
        return new Location($attributes);
    }

    /**
     * Get configuration value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }
}