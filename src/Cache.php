<?php

namespace yzh52521\GeoIP;


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
     * cache tag
     * @var array
     */
    protected $tags;


    /**
     * Create a new cache instance.
     *
     * @param $cache
     * @param array $tags
     * @param int $expires
     */
    public function __construct(\think\Cache $cache, $tags, $expires = 30)
    {
        $this->cache   = $cache;
        $this->expires = $expires;
        $this->tags    = $tags;
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
        return $this->cache->tag($this->tags)->set($name, $location->toArray(), $this->expires);
    }

    /**
     * Flush cache for tags.
     *
     * @return bool
     */
    public function clear()
    {
        return $this->cache->tag($this->tags)->clear();
    }
}