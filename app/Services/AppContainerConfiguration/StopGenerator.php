<?php

namespace App\Services\AppContainerConfiguration;

use App\Services\AppDirectoryStructure\HostingEnvironment;

/**
 * Class StopGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\StopGenerator
 */
class StopGenerator
{
    
    /**
     * Generates the Start configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateStopConfiguration(): array
    {
        $config = '#!/bin/bash 
        docker stop $(docker ps -q)';
        $filePath = (new HostingEnvironment())->getContainersDirectoryPath(); 
        (new HostingEnvironment())->updateContainerFiles('','stop.sh', $config);
        return ["Built stop script."];
    }
}
