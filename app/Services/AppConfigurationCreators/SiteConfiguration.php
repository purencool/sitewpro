<?php

namespace App\Services\AppConfigurationCreators;


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
        "default.domain" => "", // Default domain and unique to this application across all environments.
        "software" => "", // The type of software, for example, Drupal, Joomla, Django.
        "description" => "", // Description of domain and what it is and does.
        "container_image" => array(), // Docker or podman containers need to run this application.
        "code_management" => array( // Where the code is keep so it can be pulled using git or something else.
            "url" => "", // The url to where the code is kept if null it's assume the code is manually added.
            "authentication" => array(), // The way to authenticate.
            "actions" => array("") // Actions to take on deployment.
        ),
        "domains" => array(), // Domains applied to this application
        "database_management" => array( // Database connections to be used for the application
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
        "site_directories" => array( // Default site structure
            "ssh_keys" => array(
                "path" => "ssh"
            ), // Where the ssh keys are kept
            "certs" => array(
                "path" => "certs"
            ), // SSL certs.
            "code" => array(
                "path" => "code"
            ), // Code directory.
            "web_root" => array(
                "path" => "code/docroot",
            ), // What is the public facing docroot this will be inside the code directory.
        ),
    );

    /**
     * @param string $siteName
     * @param string $path
     * @return void
     */
    public function createDefaultConfiguration(string $siteName, string $path): void
    {
        $this->siteArr["default.domain"] = $siteName;
        $jsonOutput = json_encode($this->siteArr, JSON_PRETTY_PRINT);
        file_put_contents($path . "/config.json", $jsonOutput);

        foreach ($this->siteArr["site_directories"] as $paths) {
            $createNewDirectory = $paths["path"];
            mkdir($path . "/$createNewDirectory" );
        }

        // This all can be altered through website update functionality.
        file_put_contents($path. "/" .$this->siteArr["site_directories"]['web_root']['path'] . "/index.html",
         "Welcome to your new application"
        );
    }

}

