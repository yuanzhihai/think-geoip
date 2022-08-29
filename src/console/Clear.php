<?php

namespace yzh52521\GeoIP\console;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Clear extends Command
{

    protected function configure()
    {
        $this->setName('geoip:clear')->setDescription('Clear GeoIP cached locations.');
    }

    /**
     *
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        if ($this->isSupported() === false) {
            $this->output->writeln('Default cache system does not support tags');
        }

        $this->performFlush();
    }

    /**
     * Is cache flushing supported.
     *
     * @return bool
     */
    protected function isSupported()
    {
        return empty(app('geoip')->config('cache_tags')) === false
            && in_array(config('cache.default'), ['file', 'database']) === false;
    }

    /**
     * Flush the cache.
     *
     * @return void
     */
    protected function performFlush()
    {
        $this->output->writeln("Clearing cache...");

        app('geoip')->getCache()->clear();

        $this->output->writeln("<info>complete</info>");
    }
}