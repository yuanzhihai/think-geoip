<?php
if (!function_exists('geoip')) {
    /**
     * Get the location of the provided IP.
     *
     * @param string $ip
     *
     * @return \yzh52521\GeoIP\GeoIP|\yzh52521\GeoIP\Location
     */
    function geoip($ip = null)
    {
        if (is_null($ip)) {
            return app('geoip');
        }

        return app('geoip')->getLocation($ip);
    }
}
