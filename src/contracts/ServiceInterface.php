<?php

namespace yzh52521\GeoIp\contracts;

interface ServiceInterface
{
    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot();

    /**
     * Determine a location based off of
     * the provided IP address.
     *
     * @param string $ip
     *
     * @return \yzh52521\GeoIP\Location
     */
    public function locate($ip);

    /**
     * Create a location instance from the provided attributes.
     *
     * @param array $attributes
     *
     * @return \yzh52521\GeoIP\Location
     */
    public function hydrate(array $attributes = []);

    /**
     * Get configuration value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function config($key, $default = null);
}