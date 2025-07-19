<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AppConfigurationCreators\AppConfiguration;

/**
 *
 */
class SiteCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spro:site:creation {domain?}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
        $resultsFromTheQuestions = [];
        $creation = new AppConfiguration();

        // 1. What is your unique domain or will check the one provided?
        if ($this->argument('domain')) {
           $resultsFromTheQuestions['domain'] = $this->argument('domain');
       } else {
          $domain = $this->ask('What is the systems unique domain to be used for this application (eg: hotels.com)?');
          $resultsFromTheQuestions['domain'] = $domain;
        }

        // 2. What type of software are you using?
        $softwareType = $this->ask('What type of software are you using?');
        $resultsFromTheQuestions['software_type'] = $softwareType;

        // 3. Please provide a description of what this app does.
        $description = $this->ask('Please provide a description of what this app does.');
        $resultsFromTheQuestions['description'] = $description;

        // 4. Which Docker or Podman container are you using?
        $containerType = $this->choice('Name container are you using?', ['one.yaml', 'two.yaml']);
        $resultsFromTheQuestions['container_type'] = $containerType;

        // 5. Are you using a code management tool like git?
        $gitUrl = "";
        $gitAuth = "";
        if ($this->confirm('Are you using a code management tool like git?')) {
            // Request url and authentication
            $gitUrl = $this->ask('Please provide the Git repository URL');
            $gitAuth = $this->secret('Please enter your Git authentication credentials');
        }
        $resultsFromTheQuestions['git_url'] = $gitUrl;
        $resultsFromTheQuestions['git_auth'] = $gitAuth;

        // Action updates
        $actionUpdate = $this->ask('What actions do you want to run on each deployment separate with a comma (eg: composer update, next command)?');
        $resultsFromTheQuestions['action_update'] = $actionUpdate;

        // 6. The console will then ask what domains will be used as entry points to access the application.
        $entryPoints = $this->ask('What domains will be used as entry points to access the application separate with a comma?');
        $resultsFromTheQuestions['entry_points'] = $entryPoints;

        // 7. What is the environment that this application will be deployed to?
        $environment = $this->choice('What is the environment that this application will be deployed to?', ['Development', 'Staging', 'Production']);
        $resultsFromTheQuestions['environment'] = $environment;

        // 8. What type of database names system will be used for this application?
        $databaseManagementSystem = $this->ask('What are the database names need for this application separate with a comma?');
        $resultsFromTheQuestions['database_names'] = $databaseManagementSystem;

        $this->info($creation->create($resultsFromTheQuestions));
    }
}
