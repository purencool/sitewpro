<?php

namespace App\Services\AppContainerConfiguration;

use App\Services\AppContainerConfiguration\DockerCompose\DnsGenerator;
use App\Services\AppContainerConfiguration\DockerCompose\ProxyGenerator;
use App\Services\AppContainerConfiguration\DockerCompose\StartStopGenerator;
use App\Services\AppDirectoryStructure\HostingEnvironment;

/**
 * Class ContainerConfiguration
 *
 * This class is responsible for generating Container Compose files using a generator class.
 *
 * @package App\Services\AppContainerConfiguration
 */
class ContainerConfiguration
{

    /**
     * Generate a Composer Compose file using a generator class.
     * 
     * @param $type 
     *   Setting up for different types of containerisation.
     * @param $dns
     *   Setting up for different types of dns configuration
     *
     * @return array
     */
    public function generate(string $type = 'docker_compose' , $dns = 'cordns'): array
    {
       $startStop = new StartStopGenerator();
       $dns = new DnsGenerator();
       $startStop->setPathAndFileNames($dns->fileName()); 
       $proxy = new ProxyGenerator();
       $startStop->setPathAndFileNames($proxy->fileName()); 

        return ['configuration' => [
            'dns' => $dns->generateConfiguration(),
            'proxy' => $proxy->generateProxyConfiguration(),
            'start_stop' => $startStop->generateStartStopConfiguration(),
            'backup' => (new HostingEnvironment())->createContainerConfigBackup()
        ]];
    }
}