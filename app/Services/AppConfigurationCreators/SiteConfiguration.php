<?php

namespace App\Services\AppConfigurationCreators;

use App\Services\EnvironmentVariables;

/**
 * Represents a site configuration.
 */
class SiteConfiguration
{

    /**
     * The array below is the default configuration for this site. It should it under the
     * parent directory called by the same name of the first key in the array with is stored
     * inside the environments that are set up the application installation, for example.
     *
     *   hosting (root directory)
     *     -> dev (environment directory)
     *        -> default.domain (domain directory)
     *           -> site.php (site configuration)
     *           -> certs (directory)
     *           -> ssh (directory)
     *           -> code (directory)
     *     -> test (environment directory)
     *        -> test.com (domain directory this unique and hosting)
     *           -> site.php (site configuration)
     *           -> certs (directory)
     *           -> ssh (directory)
     *           -> code (directory)
     *
     * Each part of the array is generated under App\Services\AppConfigurationCreators and you will find
     * them smaller components with interfaces and a parent class calling them when called by CLI. All
     * of these items have been tested functionally and at a class unit as well.
     *
     */
    public array $siteArr = array(
        "system" => array(
            "default.domain" => "", // Default domain and unique to this application across all environments.
            "environment" => '',
            "database" => array( // Database connections to be used for the application
                "connections" => array(
                    "one" => array(
                        "path" => "",
                        "host" => "localhost",
                        "port" => "3306",
                        "username" => "",
                        "password" => "",
                        "database" => "",
                        "table_prefix" => ""
                    ),
                    "two" => array(
                        "path" => "",
                        "host" => "localhost",
                        "port" => "3306",
                        "username" => "",
                        "password" => "",
                        "database" => "",
                        "table_prefix" => ""
                    )
                ),
            ),
            "directories" => array( // Default site structure
                "ssh_keys" => array(
                    "path" => "ssh"
                ), // Where the ssh keys are kept
                "certs" => array(
                    "path" => "certs"
                ), // SSL certs.
                "code" => array(
                    "path" => "code"
                ), // Code directory.
            ),
        ),
        "user" => array(
            "software" => "", // The type of software, for example, Drupal, Joomla, Django.
            "description" => "", // Description of domain and what it is and does.
            "container_image" => array(), // Docker or podman containers need to run this application.
            "code_management" => array( // Where the code is keep so it can be pulled using git or something else.
                "url" => "", // The url to where the code is kept if null it's assume the code is manually added.
                "authentication" => array(), // The way to authenticate.
                "actions" => array("") // Actions to take on deployment.
            ),
            "domains" => array(), // Domains applied to this application
            "web_root" => array(
                "path" => "code/docroot",
            ), // What is the public facing docroot this will be inside the code directory.
        )
    );

    /**
     * Create a sites in environments, create default configuration and default access domain.
     *
     * @param string $siteName
     * @param string $environment
     * @return void
     */
    public function createDefaultConfiguration(string $siteName, string $environment): void
    {
        $domain = (new EnvironmentVariables())->getHostingDomain();
        $path = (new EnvironmentVariables())->getHostingSiteBaseDirectoryPath() ."/" . $environment . "/" . $siteName;
        $this->siteArr["system"]["default.domain"] = $siteName;
        $this->siteArr["system"]["environment"] = $environment;
        $defaultDomain = str_replace('.', '-', $siteName) .'-'.$environment.'.'.$domain;
        $this->siteArr["user"]["domains"][] = $defaultDomain;
        $jsonOutput = json_encode($this->siteArr, JSON_PRETTY_PRINT);
        file_put_contents($path . "/config.json", $jsonOutput);

        foreach ($this->siteArr["system"]["directories"] as $paths) {
            $createNewDirectory = $paths["path"];
            mkdir($path . "/$createNewDirectory" );
        }

        // This all can be altered through website update functionality.
        mkdir($path. "/" .$this->siteArr["user"]['web_root']['path']);
        file_put_contents($path. "/" .$this->siteArr["user"]['web_root']['path'] . "/index.html",
         "Welcome to your new application: $defaultDomain"
        );
    }

    /**
     * Get sites configuration for each environment.
     *
     * @param string $siteName
     * @return array
     */
    public function getSitesConfiguration(string $siteName): array
    {
        $return = array();
        $environmentArr = (new EnvironmentVariables())->getHostingSiteEnvironmentsArray();
        foreach( $environmentArr as $environment)
        {
            $path = (new EnvironmentVariables())->getHostingSiteBaseDirectoryPath()
                ."/" . $environment
                . "/" . $siteName
                . "/config.json";
            $return[$environment] = json_decode(file_get_contents($path), true);
        }

        return $return;
    }

    /**
     * Update configuration
     *
     * @param array $data
     * @return void
     */
    public function setDefaultConfiguration(array $data): void
    {
        foreach( $data as $environmentData)
        {
            $path = (new EnvironmentVariables())->getHostingSiteBaseDirectoryPath()
                . "/" . $environmentData["system"]["environment"]
                . "/" . $environmentData["system"]["default.domain"]
                . "/config.json";
            $jsonOutput = json_encode($environmentData, JSON_PRETTY_PRINT);
            file_put_contents($path , $jsonOutput);
        }
    }
}

