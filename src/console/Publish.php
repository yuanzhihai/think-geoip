<?php

namespace yzh52521\GeoIP\console;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Publish extends Command
{

    public function configure()
    {
        $this->setName('geoip:publish')
            ->setDescription('Publish geoip resources folder');
    }

    public function execute(Input $input, Output $output)
    {
        //获取默认配置文件
        $path = root_path('resources');
        if (is_file($path) === false) {
            @mkdir($path, 0755, true);
            copy(__DIR__ . '/../../resources/geoip.mmdb', $path.'/geoip.mmdb');
        }
        $output->writeln('publish ok');
    }

}
