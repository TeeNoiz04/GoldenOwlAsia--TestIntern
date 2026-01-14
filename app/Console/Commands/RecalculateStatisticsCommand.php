<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\RecalculateSubjectStatistics;

class RecalculateStatisticsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:recalculate';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate subject score statistics';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            RecalculateSubjectStatistics::dispatchSync();
            $this->info('Job done');
        } catch (\Throwable $e) {
            dd($e->getMessage(), $e->getTraceAsString());
        }

        return self::SUCCESS;
    }
}
