<?php

namespace App\Console\Commands;

use App\Services\EnvironmentVariables;
use Illuminate\Console\Command;
use App\Services\AppConfiguration;

/**
 * Class SiteDomains
 *
 * The `cli:site:domains` console command displays the domains for a specific site.
 *
 * ## Usage
 * ```
 * php artisan cli:site:domains {default.domain}
 * ```
 *
 * ## Options
 * This command accepts the following arguments:
 * - `default.domain`: The domain of the site to retrieve the domains for.
 *
 * ## Example Output
 * ```
 * {
 *   "domain": "example.com",
 *   "domains": [
 *     "www.example.com",
 *     "api.example.com"
 *   ]
 * }
 * ```
 *
 * @package App\Console\Commands
 */
class SiteDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:domains {default.domain?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the domains for a specific site';

    /**
     * @return void
     */
    public function handle(): void
    {
        $results = (new AppConfiguration())->getDomains($this->argument('default.domain'));
        $this->info(json_encode($results, JSON_PRETTY_PRINT));
    }
}