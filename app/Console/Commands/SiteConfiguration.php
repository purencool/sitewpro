<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AppConfigurationCreators\AppConfiguration;

/**
 *
 */
class SiteConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spro:site:config {domain?}';


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
        $results = (new AppConfiguration())->getConfiguration($this->argument('domain'));
        $this->info(json_encode($results, true));
    }
}
