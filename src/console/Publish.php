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
        $resources = __DIR__ . '/../../resources';
        $this->xCopy($resources, root_path('resources'));
        $output->writeln('publish ok');
    }

    public function xCopy($source, $destination, $child = 1)
    {
        if (!is_dir($source)) {
            echo("Error:the $source is not a direction!");
            return 0;
        }
        if (!is_dir($destination)) {
            if (!mkdir($destination, 0777) && !is_dir($destination)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $destination));
            }
        }
        $handle = dir($source);
        while ($entry = $handle->read()) {
            if (($entry !== ".") && ($entry !== "..")) {
                if (is_dir($source . "/" . $entry)) {
                    if ($child) {
                        $this->xCopy($source . "/" . $entry, $destination . "/" . $entry, $child);
                    }
                } else {
                    copy($source . "/" . $entry, $destination . "/" . $entry);
                }
            }
        }
    }

}
