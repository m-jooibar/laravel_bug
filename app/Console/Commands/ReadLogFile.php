<?php

namespace App\Console\Commands;

use App\Console\Commands\Helpers\PrepareLog;
use Illuminate\Console\Command;

class ReadLogFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:read {log}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read logs from a log file or url';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $log = $this->argument('log');
        $processLog = (new PrepareLog($log))->execute();
        $this->info($processLog);
    }
}
