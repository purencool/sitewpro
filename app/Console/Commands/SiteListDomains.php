<?php

namespace App\Console\Commands;

use App\Services\EnvironmentVariables;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AppRestApi;

/**
 * Class SiteListDomains
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
 * - `default.domain`: The domain of the site to retrieve the configuration for.
 *
 * ## Example Output
 * ```
 * {
 *   "domain": "example.com",
 *   "settings": {
 *     "theme": "default",
 *     "language": "en"
 *   }
 * }
 * ```
 *
 * @package App\Console\Commands
 */
class SiteListDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:domains:list';

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
        $jsonData = json_encode([
            'response_format' => 'raw',
            'request_type' => 'sites_domains_list',
        ]);

        $request = Request::create(
            '/', 
            'GET', 
            [],
            [], 
            [], 
            ['CONTENT_TYPE' => 'application/json'], 
            $jsonData 
        );

        $creation = new AppRestApi();
        $this->info(
            json_encode($creation->RequestHandler($request),JSON_PRETTY_PRINT)
        );
    }
}
