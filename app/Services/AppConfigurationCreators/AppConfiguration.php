<?php

namespace App\Services\AppConfigurationCreators;

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
        $uniqueDomain = $resultsFromTheQuestions['domain'];
        unset($resultsFromTheQuestions['domain']);
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
     * @param string $siteName
     * @param array $arrayUpdates
     * @param string $environment
     * @return void
     */
    public function update(string $siteName, array $arrayUpdates, string $environment = 'all'): void
    {
        $siteArray = (new SiteConfiguration())->getSitesConfiguration($siteName);
        if($environment == 'all') {
            foreach($siteArray as $siteKey => $site) {
                $siteArray[$siteKey]['user'] = array_merge_recursive($siteArray[$siteKey]['user'], $arrayUpdates);
            }
        } else {
            $siteArray[$environment] = array_merge_recursive($siteArray[$environment]['user'],  $arrayUpdates);
        }

        (new SiteConfiguration())->setDefaultConfiguration($siteArray);
    }

    /**
     * @param $domain
     * @param $defaultDomain
     * @return void
     */
    public function delete($domain, $defaultDomain): void
    {
        // Delete the site configuration from storage
    }

    /**
     * Get all configuration for a domain
     *
     * @param $domain
     * @return array
     */
    public function getConfiguration($domain): array
    {
        return (new SiteConfiguration())->getSitesConfiguration($domain);
    }
}
