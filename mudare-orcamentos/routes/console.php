<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Limpeza diária dos exports CSV com mais de 7 dias (evita acúmulo em disco).
// Em HostGator/cPanel, agende um Cron Job diário rodando:
//   php /home/USUARIO_CPANEL/laravel-orcamentos/artisan schedule:run
// (ou diretamente: php artisan exports:cleanup --days=7)
Schedule::command('exports:cleanup --days=7')->dailyAt('03:17');
