<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\EstudianteEventoController;
use App\Http\Controllers\RegistroEventoController;
use App\Http\Controllers\EstudianteNotificacionController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReporteAsistenciaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth', 'estudiante'])->group(function () {
    Route::get('/estudiante/dashboard', function () {
        return view('estudiante.dashboard');
    });
});

Route::get('/redirect-by-role', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();

    if ($user->role->nombre === 'Administrador') {
        return redirect('/admin/dashboard');
    }

    return redirect('/estudiante/dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('eventos', EventoController::class);
});

Route::middleware(['auth', 'estudiante'])->get('/eventos/activos', function () {
    $eventos = \App\Models\Evento::where('fecha', '>=', now())->orderBy('fecha')->get();
    return view('estudiante.eventos', compact('eventos'));
});

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

// RUTA PARA ESTUDIANTES — VER EVENTOS ACTIVOS
Route::get('/estudiante/eventos', [EstudianteEventoController::class, 'index'])
    ->middleware(['auth', 'estudiante'])
    ->name('estudiante.eventos');

Route::get('/estudiante/eventos/{id}', [EstudianteEventoController::class, 'show'])
    ->middleware(['auth', 'estudiante'])
    ->name('estudiante.eventos.show');

Route::post('/estudiante/eventos/{id}/registrarse', [RegistroEventoController::class, 'store'])
    ->middleware(['auth', 'estudiante'])
    ->name('estudiante.registrarse');

Route::post('/estudiante/eventos/{id}/registrarse', [RegistroEventoController::class, 'store'])
    ->middleware(['auth', 'estudiante'])
    ->name('estudiante.registrarse');

Route::get('/estudiante/notificaciones', [EstudianteNotificacionController::class, 'index'])
    ->middleware(['auth', 'estudiante'])
    ->name('estudiante.notificaciones');

Route::get('/estudiante/mis-eventos', [EstudianteEventoController::class, 'misEventos'])
    ->middleware(['auth', 'estudiante'])
    ->name('estudiante.mis-eventos');

Route::post('/estudiante/mis-eventos/{registroId}/cancelar', [RegistroEventoController::class, 'cancel'])
    ->middleware(['auth', 'estudiante'])
    ->name('estudiante.mis-eventos.cancelar');

Route::get('/estudiante/registro/{id}/qr', [RegistroEventoController::class, 'qr'])
    ->middleware(['auth', 'estudiante'])
    ->name('registro.qr');

Route::middleware(['auth', 'admin'])->group(function () {

    // Lector QR
    Route::get('/admin/lector-qr', [AsistenciaController::class, 'scanner'])
        ->name('admin.qr.scanner');

    // Registrar asistencia vía AJAX
    Route::post('/admin/registrar-asistencia', [AsistenciaController::class, 'registrar'])
        ->name('admin.qr.registrar');
});

Route::get('eventos/{id}/export/csv', [ReporteAsistenciaController::class, 'exportCsv'])->name('eventos.export.csv');
Route::get('eventos/{id}/export/pdf', [ReporteAsistenciaController::class, 'exportPdf'])->name('eventos.export.pdf');

Route::get('/', [HomeController::class, 'index'])->name('home');




require __DIR__ . '/auth.php';
