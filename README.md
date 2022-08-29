# think-geoip
Determine the geographical location of website visitors based on their IP addresses

# 基本用法
> The simplest way to use these method is through the helper function geoip() or by using the facade \yzh52521\GeoIP\facades\GeoIP. For the examples below we will use the helper method.

获取网站访问者的位置数据：
```php
geoip($ip = null);
```
Arguments:
$ip - The Ip to look up. If not set the application default to the remote address.示例：
```php
\yzh52521\GeoIP\Location {

    #attributes:array [
        'ip'           => '232.223.11.11',
        'iso_code'     => 'US',
        'country'      => 'United States',
        'city'         => 'New Haven',
        'state'        => 'CT',
        'state_name'   => 'Connecticut',
        'postal_code'  => '06510',
        'lat'          => 41.28,
        'lon'          => -72.88,
        'timezone'     => 'America/New_York',
        'continent'    => 'NA',
        'currency'     => 'USD',
        'default'      => false,
    ]
}
```
Default Location
In the case that a location is not found the fallback location will be returned with the default parameter set to true. To set your own default change it in the configurations config/geoip.php

# think Commands

publish Service Data
```
php think geoip:publish
```

Updating Service Data
Some services may need to update local files. For example the MaxMind Database service fetches a remote database and saves it to the local file system.
```
php think geoip:update
```
Clearing Cached Locations
Some cache drivers offer the ability to clear stored location.
```
php think geoip:clear
```

# Methods
When the geoip() helper function is used without arguments it will return the \Torann\GeoIP\GeoIP instance, and with this we can do all types of amazing things.
```
getLocation($ip = null)
```
Get the location from the provided IP.

Arguments:

$ip - The Ip to look up. If not set the application default to the remote address.
```
geoip()->getLocation('27.974.399.65');
```
getService()
Will return the default service used for determining location.
```
getClientIP()
```
Will return the user IP address.

# Services
Service Prerequisites
Before using the MaxMind driver, you will need to install the appropriate package via Composer:

MaxMind: geoip2/geoip2 ~2.1
IP-API (default)
They offer a free and pro service ip-api.com
```
'service' => 'ipapi',
```
MaxMind Database
The database location to used is specified in the config file in the services section under maxmind_database. Along with the URL of where to download the database from when running the php artisan geoip:update. Note: The geoip:update command will need to be ran before the package will work.
```
'service' => 'maxmind_database',
```
Optimization Tip: When using the database option I don't like having the downloaded database in my git repository, so I have my deploy system run the geoip:update during the build process before it's deployed to the servers.

MaxMind API
Register for a license key and user ID at www.maxmind.com
```
'service' => 'maxmind_api',
```
IPGEOLOCATION API
Register at ipgeolocation.io to get api key and add it into your env file as: IPGEOLOCATION_KEY = YOUR_API_KEY
```
'service' => 'ipgeolocation',
```
IPFINDER API
Register at ipfinder.io to get api key and add it into your env file as: IPFINDER_API_KEY = YOUR_API_KEY
```
'service' => 'ipfinder',
```
IPDATA API
Register at ipdata.co to get api key and add it into your env file as: IPDATA_API_KEY = YOUR_API_KEY
```
'service' => 'ipdata',
```
Custom Service
Services are stored in the GeoIP's config file config/geoip.php. Simply update the service with the name of your custom service and add it to the services specific configuration section with the class value as the custom classname.

Example service
```
<?php

namespace App\GeoIP\Services;

use Exception;
use Torann\GeoIP\Support\HttpClient;
use Torann\GeoIP\Services\AbstractService;

class FooBar extends AbstractService
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
        $this->client = new HttpClient([
            'base_uri' => 'http://api.foobar-ip-to-location.com/',
            'query' => [
                'some_option' => $this->config('some_option'),
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function locate($ip)
    {
        // Get data from client
        $data = $this->client->get('find', [
            'ip' => $ip,
        ]);

        // Verify server response
        if ($this->client->getErrors() !== null) {
            throw new Exception('Request failed (' . $this->client->getErrors() . ')');
        }

        // Parse body content
        $json = json_decode($data[0]);

        return [
            'ip' => $ip,
            'iso_code' => $json->iso_code,
            'country' => $json->country,
            'city' => $json->city,
            'state' => $json->state,
            'state_name' => $json->state_name,
            'postal_code' => $json->postal_code,
            'lat' => $json->lat,
            'lon' => $json->lon,
            'timezone' => $json->timezone,
            'continent' => $json->continent,
        ];
    }

    /**
     * Update function for service.
     *
     * @return string
     */
    public function update()
    {
        // Optional artisan command line update method
    }
}
```
In the config file
```
'service' => 'foobar',

'services' => [

    ...

    'foobar' => [
        'class' => \App\GeoIP\Services\FooBar::class,
        'some_option'  => 'some_option_value',
    ],

],
```