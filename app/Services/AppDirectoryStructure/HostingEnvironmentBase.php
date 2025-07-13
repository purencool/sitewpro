<?php

namespace App\Services\AppDirectoryStructure;

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
     * @var string
     */
    protected string $defaultPath;

    /**
     * @var array
     */
    protected array $environments;

    /**
     *
     */
    public function __construct(){
        $this->getDefaultPath();
        $this->getEnvironments();
    }

    /**
     * Get the default hosting site path from the environment.
     *
     * @return string
     */
    public function getDefaultPath(): string
    {
        $this->defaultPath = app_path(
          "/../../". env('HOSTING_SITE_DEFAULT_PATH', 'default_path')
        );
        return $this->defaultPath;
    }


    /**
     * Create a directory at the given path if it does not exist.
     *
     * @return bool
     */
    public function createBaseDirectory(): bool
    {
        if (!is_dir($this->defaultPath)) {
            return mkdir($this->defaultPath, 775, true);
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
        if (is_dir($this->defaultPath)) {
            return rmdir($this->defaultPath);
        }
        return true;
    }

    /**
     * Returns base path string.
     *
     * @return string
     */
    public function getBaseDirectoryPathName(): string
    {
        return env('HOSTING_SITE_DEFAULT_PATH', 'default_path');
    }

    /**
     * Returns base directory name string.
     *
     * @return string
     */
    public function getBaseDirectoryPath(): string
    {
        return $this->defaultPath;
    }

    /**
     * Get the hosting site environments as an array from the environment.
     *
     * @return array
     */
    public function getEnvironments(): array
    {
        $hostEnvironments =explode(',', env('HOSTING_SITE_ENVIRONMENTS', '[]'));
        $this->environments = is_array($hostEnvironments) ? $hostEnvironments : [];
        return $this->environments;
    }

}
