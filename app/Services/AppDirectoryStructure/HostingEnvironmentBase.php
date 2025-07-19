<?php

namespace App\Services\AppDirectoryStructure;

use App\Services\EnvironmentVariables;

/**
 * Class HostingEnvironmentManager
 *
 * Handles retrieval of hosting environment variables and directory creation.
 *
 * @package App\Services
 */
class HostingEnvironmentBase
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
    public function createEnvironmentDirectories(): bool
    {
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach ($environmentArr as $environment) {
            if (!is_dir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment)) {
                 mkdir($this->envVar->getHostingSiteBaseDirectoryPath() ."/" . $environment,);
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
}
