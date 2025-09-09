<?php

namespace App\Services\AppDirectoryStructure;

use App\Services\AppConfigurationCreators\SiteConfiguration;
use App\Services\EnvironmentVariables;

/**
 * Class HostingEnvironmentManager
 *
 * Handles retrieval of hosting environment variables and directory creation.
 *
 * @package App\Services
 */
class HostingEnvironment
{
    /**
     * @var object
     */
    protected object $envVar;

    /**
     *
     */
    public function __construct(){
      $this->envVar = new EnvironmentVariables();
    }

    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createBaseDirectory(): bool
    {
        if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath())) {
            return mkdir($this->envVar->getHostingSiteBaseDirectoryPath());
        }
        return true;
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyBaseDirectory(): bool
    {
        if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath())) {
            return rmdir($this->envVar->getHostingSiteBaseDirectoryPath());
        }
        return true;
    }

    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createConfigDirectory(): bool
    {
        if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config")) {
            return mkdir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config");
        }
        return true;
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyConfigDirectory(): bool
    {
        if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config")) {
            return rmdir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config");
        }
        return true;
    }


    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createContainersDirectory(): bool
    {
        if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config/containers")) {
            return mkdir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config/containers");
        }
        return true;
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyContainersDirectory(): bool
    {
        if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config/containers")) {
            return rmdir($this->envVar->getHostingSiteBaseDirectoryPath()."/.config/containers");
        }
        return true;
    }

    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createEnvironmentDirectories(): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment)) {
                 mkdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment);
            }
        }
        return true;
    }

    /**
     * Destroy a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function destroyEnvironmentDirectories(): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment)) {
                rmdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment);
            }
        }
        return true;
    }

    /**
     * Count if sites are in environment.
     *
     * @param string $siteName
     * @return int
     */
    public function sitesEnvironmentDirectoriesCount(string $siteName): int
    {
        $siteNameCount = 0;
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment)) {
                if (is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment."/" . $siteName)) {
                   $siteNameCount++;
                }
            }
        }
        return $siteNameCount;
    }

    /**
     * Create site directories.
     *
     * @param string $siteName
     * @return bool
     */
    public function createSiteDirectories(string $siteName): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName)) {
                mkdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName);
            }
        }
        return true;
    }

    /**
     * Destroy site directories.
     *
     * @param string $siteName
     * @return bool
     */
    public function destroySiteDirectories(string $siteName): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName)) {
                rmdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName);
            }
        }
        return true;
    }

    /**
     * Create site configuration.
     *
     * @param string $siteName
     * @return bool
     */
    public function createSiteDefaultConfiguration(string $siteName): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_file($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName)) {
                (new siteConfiguration())->createDefaultConfiguration(
                    $siteName,
                    $environment,
                );
            }
        }
        return true;
    }
}
