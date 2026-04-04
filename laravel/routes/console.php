<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// worksの自動同期ジョブを1時間ごとに実行する
Schedule::command('works:sync')->hourly();

// CSVからのメンバー情報インポートを1時間ごとに実行する
Schedule::command('members:import')->hourly();
