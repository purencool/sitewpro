<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AppConfigurationCreators\AppConfiguration;

class SiteDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spro:site:delete {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete an existing site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
        // Get the default domain from the environment variable
        $defaultDomain = env('HOSTING_SITE_DEFAULT_PATH');

        // Create a new instance of AppConfigurationCreators
        $creators = new AppConfiguration();

        // Call the delete method to delete an existing site configuration
        $creators->delete($this->argument('domain'), $defaultDomain);
    }
}
