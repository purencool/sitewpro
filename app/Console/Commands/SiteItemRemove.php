<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AppConfiguration;

/**
 * Class SiteItemRemove
 *
 * The `cli:site:item:remove` console command removes an existing item from the site configuration.
 *
 * ## Usage
 * ```
 * php artisan cli:site:item:remove {default.domain} {environment} {json_string}
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
class SiteItemRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:site:item:remove {default.domain} {environment} {json_string}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an existing site configuration';

    /**
     * @return void
     */
    public function handle(): void
    {
        $resultsFromTheQuestions = [];
        $creation = new AppConfiguration();
        $resultsFromTheQuestions['default.domain'] = $this->argument('default.domain');
        $resultsFromTheQuestions['user']= json_decode( $this->argument('json_string'), true);
        $resultsFromTheQuestions['environment'] = $this->argument('environment');
        $this->info($creation->remove(
            $resultsFromTheQuestions['default.domain'],
            $resultsFromTheQuestions["user"],
            $resultsFromTheQuestions['environment'],
           )
        );

    }
}
