<?php

namespace App\Console\Commands;

use App\Services\EnvironmentVariables;
use Illuminate\Console\Command;
use App\Services\AppConfigurationCreators\AppConfiguration;

/**
 *
 */
class SiteDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spro:site:domains {domain?}';


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

        // 1. What is your unique domain or will check the one provided?
        if ($this->argument('domain')) {
           $resultsFromTheQuestions['domain'] = $this->argument('domain');
        } else {
          $domain = $this->ask('What is the systems unique domain to be used for this application (eg: hotels.com)?');
          $resultsFromTheQuestions['domain'] = $domain;
        }

        // 2. The console will then ask what domains will be used as entry points to access the application.
        $entryPoints = $this->ask('What domains will be used as entry points to access the application separate with a comma?');
        $resultsFromTheQuestions['entry_points'] = $entryPoints;

        // 3. What is the environment that this application will be deployed to?
        $environment = $this->choice(
            'What is the environment that this application will be deployed to?',
            (new EnvironmentVariables())->getHostingSiteEnvironmentsArray()
        );
        $resultsFromTheQuestions['environment'] = $environment;
    }
}
