<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =  'Clear Laravel log files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logPath = storage_path('logs/laravel.log');

        if (file_exists($logPath)) {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('auth:clear-resets');
            Artisan::call('optimize:clear');
            Artisan::call('config:cache');
            file_put_contents($logPath, ''); // Clear content
            $this->info('Logs have been cleared.');
        } else {
            $this->info('Log file does not exist.');
        }
    }
}
