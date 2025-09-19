<?php

namespace App\Services\AppContainerConfiguration\DockerCompose;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;
use App\Services\JsonRequestObject;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ProxyGenerator
 *
 * This class generates proxy configuration for multiple server names.
 *
 * @package App\Services\AppConfigurationCreator
 */
class ProxyGenerator extends Generator
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
    * 
    */
   protected array $proxyYamlArr = [
        'services' => [
            'nginx' => [
                'image' => 'nginx:latest',
                'ports' => ['80:80'],
                'volumes' => ['./nginx.conf:/etc/nginx/conf.d/default.conf:ro'],
            ],
        ],
    ];
  

    /**
     * Generates the Nginx configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateProxyConfiguration(): array
    {

        $domainList = (new JsonRequestObject())->getResults(
                    [ 
                        'request_type' => 'sites_list_domains',
                        'response_format' => 'raw'
                    ]
                    );

        return [
            'domain_list' => $domainList,
            'proxy' => $this->proxyConfigCreation($domainList),
            'container' => $this->containerYamlCreation('proxy','docker-composer_proxy.yml', $this->proxyYamlArr),
        ];
    }

    /**
     * @inherit
     */
    public function fileName():string 
    {
        return 'proxy/docker-composer_proxy.yml';
    }
}
