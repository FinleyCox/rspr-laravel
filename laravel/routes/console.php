<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// worksの自動同期ジョブを1時間ごとに実行する（必要に応じて適宜 ->everyMinute() や ->daily() に変更可能）
Schedule::command('works:sync')->hourly();
