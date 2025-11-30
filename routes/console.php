<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Ejemplo de comando por defecto
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Mostrar una frase inspiradora');

// ===============================
// 🚀 PROGRAMACIÓN DEL SCHEDULER
// ===============================
Schedule::command('siceu:recordatorios')->dailyAt('08:00');
