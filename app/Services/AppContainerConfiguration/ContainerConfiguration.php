<?php

namespace App\Services\AppContainerConfiguration;


use App\Services\AppContainerConfiguration\ProxyGenerator;
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
     * @return array
     */
    public function generate(string $type = 'all'): array
    {
        return ['configuration' => [
            'proxy' => (new ProxyGenerator())->generateProxyConfiguration(),
            'start' => (new StartGenerator())->generateStartConfiguration(),
            'stop' => (new StopGenerator())->generateStopConfiguration(),
            'backup' => (new HostingEnvironment())->createContainerConfigBackup()
        ]];
    }
}