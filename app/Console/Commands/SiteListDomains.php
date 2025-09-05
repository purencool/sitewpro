<?php

namespace App\Console\Commands;

use App\Services\EnvironmentVariables;
use Illuminate\Console\Command;
use App\Services\AppConfigurationCreators\AppConfiguration;

/**
 *
 */
class SiteListDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spro:site:domains:list';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all domains for all environments';

    /**
     * @return 
     */
    public function handle(): void
    {
        $creation = new AppConfiguration();
        $this->info(json_encode($creation->getListDomains(),JSON_PRETTY_PRINT));
    }
}
