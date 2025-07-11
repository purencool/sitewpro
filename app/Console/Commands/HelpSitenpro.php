<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class HelpSitenpro
 *
 * The `Sitenpro:help` console command displays detailed help information
 * about the Sitenpro application, its available commands, and usage instructions.
 *
 * ## Usage
 * ```
 * php artisan Sitenpro:help
 * ```
 *
 * ## Options
 * This command does not accept any arguments or options.
 *
 * ## Example Output
 * ```
 * Sitenpro Help
 * -------------
 * Available commands:
 *   Sitenpro:help    Show this help message
 * ```
 *
 * @package App\Console\Commands
 */
class HelpSitenpro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Sitenpro:help';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display help information for Sitenpro commands';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('-------------------------------------');
        $this->info('Sitenpro Help');
        $this->line('-------------------------------------');
        $this->line('Available commands:');
        $this->line('Sitenpro:help  Show this help message');
        $this->line('-------------------------------------');
        return 0;
    }
}
