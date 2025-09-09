<?php

namespace App\Services\AppContainerConfiguration;


use App\Services\AppConfigurationCreators\NginxConfigGenerator;

/**
 * Class ContainerConfiguration
 *
 * This class is responsible for generating Docker Compose files using a generator class.
 *
 * @package App\Services\AppContainerConfiguration
 */
class ContainerConfiguration
{

    /**
     * Generate a Docker Compose file using a generator class.
     *
     * @return array
     */
    public function generate(): array
    {
        return ['results' => [
            'nginx' => (new NginxConfigGenerator())->generateNginxConfig()
        ]];
    }
}