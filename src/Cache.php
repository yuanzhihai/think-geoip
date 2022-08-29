<?php

namespace yzh52521\GeoIp;


class Cache
{
    /**
     * Instance of cache manager.
     * @var \think\Cache
     */
    protected $cache;

    /**
     * Lifetime of the cache.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new cache instance.
     *
     * @param \think\Cache $cache
     * @param array $tags
     * @param int $expires
     */
    public function __construct(Cache $cache, $tags, $expires = 30)
    {
        $this->cache   = $tags ? $cache->tag($tags) : $cache;
        $this->expires = $expires;
    }

    /**
     * Get an item from the cache.
     *
     * @param string $name
     *
     * @return Location|null
     */
    public function get($name)
    {
        $value = $this->cache->get($name);

        return is_array($value)
            ? new Location($value)
            : null;
    }

    /**
     * Store an item in cache.
     *
     * @param string $name
     * @param Location $location
     *
     * @return bool
     */
    public function set($name, Location $location)
    {
        return $this->cache->set($name, $location->toArray(), $this->expires);
    }

    /**
     * Flush cache for tags.
     *
     * @return bool
     */
    public function clear()
    {
        return $this->cache->clear();
    }
}