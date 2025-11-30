<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;

class EstudianteNotificacionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener IDs de los eventos donde el estudiante está inscrito
        $eventosInscrito = Registro::where('user_id', $user->id)
            ->where('estado', 'INSCRITO')
            ->pluck('evento_id');

        // Traer notificaciones de esos eventos
        $notificaciones = Notificacion::whereIn('evento_id', $eventosInscrito)
            ->orderBy('fecha_envio', 'desc')
            ->get();

        return view('estudiante.notificaciones.index', compact('notificaciones'));
    }
}
