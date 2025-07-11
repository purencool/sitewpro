<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Class HelpSitewpro
 *
 * The `sitewpro:help` console command displays detailed help information
 * about the Sitewpro application, its available commands, and usage instructions.
 *
 * ## Usage
 * ```
 * php artisan sitewpro:help
 * ```
 *
 * ## Options
 * This command does not accept any arguments or options.
 *
 * ## Example Output
 * ```
 * Sitewpro Help
 * -------------
 * Available commands:
 *   sitewpro:help    Show this help message
 * ```
 *
 * @package App\Console\Commands
 */
class HelpSitewpro extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitewpro:help';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display help information for Sitewpro commands';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('-------------------------------------');
        $this->info('Sitewpro Help');
        $this->line('-------------------------------------');
        $this->line('Available commands:');
        $this->line('sitewpro:help  Show this help message');
        $this->line('-------------------------------------');
        return 0;
    }
}
