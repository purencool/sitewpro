<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;

/**
 * Class DnsGenerator
 *
 * This class Dns configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class DnsGenerator extends Generator
{
    
    /**
     * An array of server names and their configurations.
     * 
     * This array need to create the following Nginx configuration:
     * 
     * @example
     *
     * @var array
     */
    protected array $config = [
        '.' => [
            'whoami' => '',
            'log' => '',
        ]
   ];

   /**
    * 
    */
    protected array $yamlArr = [
        'services' => [
            'coredns' => [
                'image' => 'coredns/coredns:latest',
                'container_name' => 'coredns',
                'command' => '-conf /etc/coredns/Corefile',
                'ports' => ['53:53/udp','53:53/tcp'],
                'volumes' => ['./conf:/etc/coredns'],
                'restart' => 'on-failure',
            ],
        ],
    ];
  
    /**
     * Generates the Nginx configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateConfiguration(): array
    {
        return [
            'config' => $this->configCreation('dns', 'Corefile', $this->config),
            'container' => $this->containerYamlCreation('dns', 'docker-composer_dns.yml', $this->yamlArr), 
        ];
    }

    
    /**
     * @inherit
     */
    public function fileName():string 
    {
        return 'dns/docker-composer_dns.yml';
    }
}
