<?php

namespace App\Services\AppConfigurationCreators;

use App\Services\AppConfigurationCreators\Items\ArrayRemove;
use App\Services\AppConfigurationCreators\Items\ArrayUpdate;
use App\Services\AppDirectoryStructure\HostingEnvironment;

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
        $manager = new HostingEnvironment();
        $manager->createBaseDirectory();
        $manager->createEnvironmentDirectories();
        $uniqueDomain = $resultsFromTheQuestions['default.domain'];
        if($manager->sitesEnvironmentDirectoriesCount($uniqueDomain) > 0) {
            return $uniqueDomain. ' unique domain already exists and can\'t be use.';
        }
        preg_replace('/[^a-zA-Z0-9.]/', '', $uniqueDomain);
        $manager->createSiteDirectories(strtolower($uniqueDomain));
        $manager->createSiteDefaultConfiguration($uniqueDomain);
        $this->update($uniqueDomain, $resultsFromTheQuestions);
        return "$uniqueDomain has been created successfully.";
    }

    /**
     * Update site arrays for configuration.
     *
     * @param string $siteName
     * @param array $arrayUpdates
     * @param string $environment
     * @return string
     */
    public function update(string $siteName, array $arrayUpdates, string $environment = 'all'): string
    {
        $siteArray = (new SiteConfiguration())->getSitesConfiguration($siteName);

        $upDatedArray = (new ArrayUpdate())->update($siteArray, $arrayUpdates, $environment);
        (new SiteConfiguration())->setDefaultConfiguration($upDatedArray);
        return json_encode((new SiteConfiguration())->getSitesConfiguration($siteName)[$environment], JSON_PRETTY_PRINT);
    }

    /**
     * @param string $siteName
     * @param array $arrayUpdates
     * @param string $environment
     * @return string
     */
    public function remove(string $siteName, array $arrayUpdates, string $environment ): string
    {
        $siteArray = (new SiteConfiguration())->getSitesConfiguration($siteName);
        $cleaner = new ArrayRemove();
        $cleaner->setArray($siteArray[$environment]['user']);
        $cleaner->remove($arrayUpdates['path'], $arrayUpdates['item']);
        $siteArray[$environment]['user'] = $cleaner->getArray();
         (new SiteConfiguration())->setDefaultConfiguration($siteArray);
         return json_encode($siteArray[$environment], JSON_PRETTY_PRINT);
    }

    /**
     * Get all configuration for a siteName
     *
     * @param $siteName
     * @return array
     */
    public function getConfiguration($siteName): array
    {
        return (new SiteConfiguration())->getSitesConfiguration($siteName);
    }
}
