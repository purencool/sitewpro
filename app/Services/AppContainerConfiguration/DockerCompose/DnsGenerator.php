<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DnsGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class DnsGenerator
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
                'ports' => ['- "53:53/udp"','- "53:53/tcp"'],
                'volumes' => ['- ./conf:/etc/coredns'],
                'restart' => 'on-failure',
            ],
        ],
    ];

    /**
     * Recursively creates Nginx configuration blocks from an associative array.
     *
     * @param array $config The configuration array.
     * @param int $indentLevel The current indentation level.
     * @return string The generated Nginx configuration block.
     */
    protected function createConfigBlock(array $config, int $indentLevel = 0): string
    { 
        $indent = str_repeat('    ', $indentLevel);
        $pConfig = '';

        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $pConfig .= "{$indent}{$key} {\n";
                $pConfig .= $this->createConfigBlock($value, $indentLevel + 1);
                $pConfig .= "{$indent}}\n";
            } else {
                $pConfig .= "{$indent}{$key} {$value}\n";
            }
        }

        return $pConfig;
    }

   
    /**
     * Create the configuration for the Nginx server.
     * 
     * @return array
     */
    protected function configCreation($domainList): array
    {
        $proxyConfig = '';
        $proxyConfig .= $this->createConfigBlock($this->config);

        (new HostingEnvironment())->updateContainerFiles('dns', 'Corefile', $proxyConfig);

        return [
            'config_file' => '/Corefile',
            'config' => $proxyConfig,
        ];
    }

    /**
     * Create the proxy configuration for the Nginx server.
     * 
     * @return array
     */
    protected function containerCreation(): array
    {
       $config = Yaml::dump($this->yamlArr, 4, 2, Yaml::DUMP_MULTI_LINE_LITERAL_BLOCK);
     
        (new HostingEnvironment())->updateContainerFiles('dns','docker-composer_dns.yml', $config);
        return [];
    }

    /**
     * Generates the Nginx configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateConfiguration(): array
    {

   

        return [
            'config' => $this->configCreation([]),
            'container' => $this->containerCreation(), 
        ];
    }
}
