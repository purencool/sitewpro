<?php

namespace App\Services\AppContainerConfiguration;

use Illuminate\Http\Request;
use App\Services\AppDirectoryStructure\HostingEnvironment;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller as AppRestApi;

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
    protected function createNginxConfigBlock(array $config, int $indentLevel = 0): string
    { 
        $indent = str_repeat('    ', $indentLevel);
        $nginxConfig = '';

        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $nginxConfig .= "{$indent}{$key} {\n";
                $nginxConfig .= $this->createNginxConfigBlock($value, $indentLevel + 1);
                $nginxConfig .= "{$indent}}\n";
            } else {
                $nginxConfig .= "{$indent}{$key} {$value}\n";
            }
        }

        return $nginxConfig;
    }


    /**
     * Generates the Nginx configuration array for each server name in the array.
     *
     * @return array
     */
    public function generateNginxConfig(): array
    {
        $nginxConfig = '';
        $jsonData = json_encode([
            'response_format' => 'raw',
            'request_type' => 'sites_list_domains',
        ]);

        $request = Request::create(
            '/', 
            'GET', 
            [],
            [], 
            [], 
            ['CONTENT_TYPE' => 'application/json'], 
            $jsonData 
        );

        $creation = new AppRestApi();
        $domainList = $creation->RequestHandler($request);
        foreach ($domainList as $site) {
            $this->serverNames['server']['server_name'] = $site['domain'] . ';';
            $this->serverNames['server']['location /']['proxy_pass'] = 'http://' . $site['environment'] . '_cfapp:80;';
            $nginxConfig .= $this->createNginxConfigBlock($this->serverNames) . "\n";
        }

        $filePath = (new HostingEnvironment())->getContainersDirectoryPath();
        file_put_contents($filePath.'/nginx.conf', $nginxConfig);
        
        return [
            'domain_list' => $domainList,
            'nginx_config_path' => $filePath.'/nginx.conf',
            'nginx_config' => $nginxConfig
        ];
    }
}
