<?php

namespace App\Services\AppContainerConfiguration;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;

/**
 * Class ProxyGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class ProxyGenerator
{
    
    /**
     * An array of server names and their configurations.
     * 
     * This array need to create the following Nginx configuration:
     * 
     * @example
     * ```
     *  server {
     *    listen 80;
     *    server_name <domaian1> <domain2>;
     *    location / {
     *       proxy_pass <domain proxy>:80;
     *       proxy_set_header Host $host;
     *       proxy_set_header X-Real-IP $remote_addr;
     *     }
     *   }
     * ```
     *
     * @var array
     */
    protected array $serverNames = [
        'server' => [
            'port' => 'listen 80;',
            'server_name' => 'example.com www.example.com;',
            'location /' => [
                'proxy_pass' => 'http://hotels_cfapp:80;',
                'proxy_set_header' => [
                    'Host' => '$host;',
                    'X-Real-IP' => '$remote_addr;',
               ],
            ],
        ]
   ];

    /**
     * Recursively creates Nginx configuration blocks from an associative array.
     *
     * @param array $config The configuration array.
     * @param int $indentLevel The current indentation level.
     * @return string The generated Nginx configuration block.
     */
    protected function createProxyConfigBlock(array $config, int $indentLevel = 0): string
    { 
        $indent = str_repeat('    ', $indentLevel);
        $pConfig = '';

        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $pConfig .= "{$indent}{$key} {\n";
                $pConfig .= $this->createProxyConfigBlock($value, $indentLevel + 1);
                $pConfig .= "{$indent}}\n";
            } else {
                $pConfig .= "{$indent}{$key} {$value}\n";
            }
        }

        return $pConfig;
    }

   
    /**
     * Create the proxy configuration for the Nginx server.
     * 
     * @return string
     */
    protected function proxyConfigCreation($domainList): string
    {
        $proxyConfig = '';
        foreach ($domainList as $site) {
            $this->serverNames['server']['server_name'] = $site['domain'] . ';';
            $this->serverNames['server']['location /']['proxy_pass'] = 'http://' . $site['environment'] . '_cfapp:80;';
            $proxyConfig .= $this->createNginxConfigBlock($this->serverNames) . "\n";
        }

        $filePath = (new HostingEnvironment())->getContainersDirectoryPath(); 
        $result = (new HostingEnvironment())->updateContainerFiles($filePath.'/nginx.conf', $proxyConfig);

        return [
            'proxy_config_path' => $filePath.'/nginx.conf',
            'proxy_config' => $proxyConfig,
            'status' => $result,
        ];
    }

    /**
     * Create the proxy configuration for the Nginx server.
     * 
     * @return array
     */
    protected function proxyContainerCreation(): array
    {
  
    }

    /**
     * Generates the Nginx configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateProxyConfiguration(): array
    {

        $domainList = (new JsonRequestObject())->getResults('sites_list_domains', 'raw');
        return [
            'domain_list' => $domainList,
            'proxy' => $this->proxyConfigCreation($domainList),
            'container' => $this->proxyContainerCreation(), 
        ];
    }
}
