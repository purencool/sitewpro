<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use App\Services\AppDirectoryStructure\HostingEnvironment;

/**
 * Class StartGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\StartGenerator
 */
class StartGenerator
{
    
    /**
     * Generates the Start configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateStartConfiguration(): array
    {
        $config = '#!/bin/bash 
        docker compose -f $1/proxy/docker-composer_proxy.yml up -d';
        $filePath = (new HostingEnvironment())->getContainersDirectoryPath(); 
        (new HostingEnvironment())->updateContainerFiles('','start.sh', $config);
        return ["Built start script."];
    }
}
