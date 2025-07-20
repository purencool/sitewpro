<?php

namespace App\Services\AppConfigurationCreators;

use Illuminate\Support\Facades\Storage;
use App\Services\EnvironmentVariables;
use App\Services\AppDirectoryStructure\HostingEnvironmentBase;

/**
 *
 */
class AppConfiguration
{
    /**
     * @param $resultsFromTheQuestions
     * @return string
     */
    public function create($resultsFromTheQuestions): string
    {
        $manager = new HostingEnvironmentBase();
        $manager->createBaseDirectory();
        $manager->createEnvironmentDirectories();
        $uniqueDomain = $resultsFromTheQuestions['domain'];
        if($manager->sitesEnvironmentDirectoriesCount($uniqueDomain) > 0) {
            return $uniqueDomain. ' already exists';
        }
        preg_replace('/[^a-zA-Z0-9.]/', '', $uniqueDomain);
        $manager->createSiteDirectories(strtolower($uniqueDomain));
        $manager->createSiteDefaultConfiguration($uniqueDomain);


        return 'Site configuration created successfully';

        // Create a new site configuration
        $site = new SiteObject();
        $site->domain = $domain;
        $site->software = '';
        $site->description = '';
        $site->container_image = [];
        $site->code_management = [
            'url' => '',
            'authentication' => [],
            'actions' => []
        ];
        $site->domains = [];
        $site->database_management = [
            'connections' => [
                'one' => [
                    'path' => '',
                    'host' => 'localhost',
                    'port' => 3306,
                    'username' => '',
                    'password' => ''
                ]
            ]
        ];

        // Save the site configuration to storage
        Storage::disk('local')->put("{$defaultDomain}/{$domain}.php", json_encode($site));

        return 'created';
    }

    /**
     * @param $domain
     * @param $defaultDomain
     * @return void
     */
    public function update($domain, $defaultDomain): void
    {
        // Get the existing site configuration from storage
        $site = json_decode(Storage::disk('local')->get("{$defaultDomain}/{$domain}.php"), true);

        // Update the site configuration
        $site['software'] = '';
        $site['description'] = '';
        $site['container_image'] = [];
        $site['code_management']['url'] = '';
        $site['code_management']['authentication'] = [];
        $site['code_management']['actions'] = [];

        // Save the updated site configuration to storage
        Storage::disk('local')->put("{$defaultDomain}/{$domain}.php", json_encode($site));
    }

    /**
     * @param $domain
     * @param $defaultDomain
     * @return void
     */
    public function delete($domain, $defaultDomain): void
    {
        // Delete the site configuration from storage
        Storage::disk('local')->delete("{$defaultDomain}/{$domain}.php");
    }
}
