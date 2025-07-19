<?php

namespace App\Services\AppConfigurationCreators;


/**
 * Class NginxConfigGenerator
 *
 * This class generates Nginx configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class NginxConfigGenerator
{
    /**
     * The array of server names to generate the configuration for.
     *
     * @var array
     */
    private array $serverNames;

    /**
     * The generated configuration array.
     *
     * @var array
     */
    private array $config;

    /**
     * Constructor.
     *
     * @param array $serverNames The array of server names to generate the configuration for.
     */
    public function __construct(array $serverNames)
    {
        $this->serverNames = $serverNames;
        $this->config = [];
    }

    /**
     * Generates the Nginx configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateConfig(): array
    {
        foreach ($this->serverNames as $serverName) {
            $this->config[] = [
                'listen' => 80,
                'server_name' => $serverName,
                'location' => '/',
                'proxy_pass' => "http://{$serverName}_",
                'proxy_set_header' => [
                    'Host' => '$host',
                    'X-Real-IP' => '$remote_addr'
                ]
            ];
        }
        return $this->config;
    }
}
