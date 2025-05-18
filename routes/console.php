<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// * 設定一個排程任務來刪除已過期超過24小時的令牌記錄
Schedule::command('sanctum:prune-expired --hours=24')
    ->daily()
    ->onOneServer();
