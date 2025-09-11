<?php

namespace App\Console\Commands;

use App\Services\EnvironmentVariables;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AppRestApi;

/**
 * Class BuildContainers
 *
 * The `cli:build:containers` console command builds all site containers.
 *
 * ## Usage
 * ```
 * php artisan cli:build:containers
 * ```
 * ## Options
 *
 * @package App\Console\Commands
 */
class BuildContainers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cli:build:containers';

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
            'request_type' => 'build_containers',
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
        //print_r($creation->RequestHandler($request)); exit;
        $this->info(
            json_encode($creation->RequestHandler($request),JSON_PRETTY_PRINT)
        );
    }
}
