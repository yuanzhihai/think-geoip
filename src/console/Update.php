<?php

namespace yzh52521\GeoIP\console;

use think\console\Command;
use think\console\Input;
use think\console\Output;

class Update extends Command
{
    protected function configure()
    {
        $this->setName('geoip:update')->setDescription('Update GeoIP database files to the latest version');
    }

    protected function execute(Input $input, Output $output)
    {
        // Get default service
        $service= app('geoip')->getService();
        // Ensure the selected service supports updating
        if (method_exists($service, 'update') === false) {
            $this->output->info('The current service "' . get_class($service) . '" does not support updating.');
            return;
        }
        $this->output->comment('Updating...');

        // Perform update
        if ($result = $service->update()) {
            $this->output->info($result);
        } else {
            $this->output->error('Update failed!');
        }
    }

}