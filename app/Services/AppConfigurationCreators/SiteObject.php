<?php

namespace App\Services\AppConfigurationCreators;


/**
 * Represents a site configuration.
 */
class SiteObject
{
    /**
     * The domain of the site.
     *
     * @var string
     */
    public string $mainDomain;

    /**
     * The software used by the site (e.g. PHP, Node.js).
     *
     * @var string
     */
    public string $software;

    /**
     * A brief description of the site.
     *
     * @var string
     */
    public string $description;

    /**
     * An array of container images used by the site.
     *
     * @var string
     */
    public string $container_image;

    /**
     * The code management settings for the site (e.g. Git, SVN).
     *
     * @var array
     */
    public array $code_management;

    /**
     * An array of domains associated with the site.
     *
     * @var array
     */
    public array $applictionDomains;

    /**
     * The database management settings for the site (e.g. MySQL, PostgreSQL).
     *
     * @var array
     */
    public array $databaseManagement;

}

