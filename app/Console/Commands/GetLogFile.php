<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetLogFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch logs from database and save in a log file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
