<?php

use App\Console\Commands\ManageSwipeRecordsTables;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(ManageSwipeRecordsTables::class)->monthlyOn(1, '00:00');
// Schedule::command('app:manage-swipe-records-tables')->monthlyOn(1, '00:00');
