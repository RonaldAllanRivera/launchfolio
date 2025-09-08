<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule monthly refresh of countries/states datasets using the app locale
Schedule::command('countries:refresh --locale=' . config('app.locale'))
    ->monthly()
    ->onOneServer()
    ->runInBackground();
