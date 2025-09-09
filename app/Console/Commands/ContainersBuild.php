<?php

namespace App\Console\Commands;

use App\Services\EnvironmentVariables;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AppRestApi;

/**
 * Class ContainerBuild
 *
 * The `cli:containers:build` console build sites containers.
 *
 * ## Usage
 * ```
 * php artisan cli:site:containers:build
 * ```
 * ## Options
 *
 * @package App\Console\Commands
 */
class ContainersBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:containers:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Container build for all sites';

    /**
     * @return 
     */
    public function handle(): void
    {
        $jsonData = json_encode([
            'response_format' => 'raw',
            'request_type' => 'containers_build',
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
