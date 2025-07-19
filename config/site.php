<?php

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
 * The site management CLI is implemented by Laravel's console with the ability to update, create and
 * delete the configuration. This is done by using the following commands.
 *
 * spro:site:creation <domain>
 * ---------------------------
 * The command creates the site by stepping through the following questions.
 *  1. What is your unique domain or will check the one provided?
 *  2. What type of software are you using?
 *  3. Please provide a description of what this app does.
 *  4. Which Docker or Podman container are you using? This will
 *     show a number of items that are kept in image store.
 *  5. Are you using a code management tool like git?
 *     If the answer is yes, it will step through code management
 *     requesting url and authentication and actions like update
 *     composer
 *  6. The console will then as what domains will be used as entry
 *     points to access the application.
 *  7. In database connections, the user will be asked how many databases
 *     the application will be needed the default will be one.
 *  8. The cli console then asks the user if they want to add ssl cert, ssh key
 *     and where the application public facing doc root will be.
 *
 *  spro:site:update <domain>
 *  -------------------------
 *  This command does everything that is in spro:site:creation except the first
 *  question check if the domain exists. It will then show all the options that the
 *  site all ready has, and the system will be requested which option needs to be updated.
 *  If the user says "all", then everything gets updates.
 *
 *  spro:site:delete <domain>
 *  -------------------------
 *  The user will be required to confirm they want to delete the application and relevant
 *  databases and then the system will back everything up and provide a path and then
 *  delete the application.
 *
 */
$site = array(
  "default.domain" => array( // Default domain and unique to this application across all environments.
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
          "ssh_keys" =>'', // Where the ssh keys are kept
          "certs" => '', // SSL certs.
          "code" => '', // Code directory.
          "web_root" => '', // What is the public facing docroot this will be inside the code directory.
      ),
  )
);
