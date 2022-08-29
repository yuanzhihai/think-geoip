<?php

namespace yzh52521\GeoIp;

use think\Service;

class GeoIPService extends Service
{
    public function register()
    {
        $this->app->bind('geoip', function ($app) {
            return new GeoIP(
                $app->config->get('geoip', []),
                $app['cache']
            );
        });
    }

    public function boot()
    {
        $this->commands([
            \yzh52521\GeoIP\console\Publish::class,
            \yzh52521\GeoIP\console\Update::class,
            \yzh52521\GeoIP\console\Clear::class,
        ]);
    }

}