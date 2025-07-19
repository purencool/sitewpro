<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AppConfigurationCreators\AppConfiguration;

class SiteUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spro:site:update {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update an existing site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
       $resultsFromTheQuestions;


       new AppConfiguration($resultsFromTheQuestions);


    }
}
