<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServeCustom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:custom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Student Score Analytics Dashboard');
        $this->line('📊 BI-style dashboard enabled');
        $this->line('🌐 Admin URL: http://127.0.0.1:8000/admin');
        $this->line('');

        // GỌI LẠI LỆNH SERVE GỐC
        $this->call('serve');

        return self::SUCCESS;
    }
}
