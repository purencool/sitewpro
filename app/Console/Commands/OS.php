<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\OperatingSystems\Debian;

/**
 * Class OS
 *
 * The `Spro:os:update` console command displays detailed help information
 * about the application, its available commands, and usage instructions.
 *
 * ## Usage
 * ```
 * php artisan Spro:os:update {password?}
 * ```
 *
 * ## Options
 * This command does not accept any arguments or options.
 *
 * ## Example Output
 * ```
 *
 * ```
 *
 * @package App\Console\Commands
 */
class OS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spro:os:update {password}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update OS software';

    /**
     * Execute the console command.
     *
     */
    public function handle() : void
    {
        $password = $this->argument('password');
        $result = (new Debian())->updateOSSoftware($password);
        $this->info($result);
        if ($result === 'updated') {
            $this->info('OS software updated successfully.');
        } else {
            $this->error('Failed to update OS software.');
        }
    }
}
