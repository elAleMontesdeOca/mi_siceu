<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Registro;
use Illuminate\Support\Facades\Auth;

class EstudianteEventoController extends Controller
{
    public function index()
    {
        // EVENTOS ACTIVOS (SOLO FUTUROS)
        $eventos = Evento::where('fecha', '>', now()->toDateString())
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return view('estudiante.eventos.index', compact('eventos'));
    }
    public function show($id)
    {
        $evento = Evento::with('categoria')->findOrFail($id);

        return view('estudiante.eventos.show', compact('evento'));
    }

    public function misEventos()
    {
        $user = Auth::user();

        // Próximos eventos (aún no pasan, INSCRITO)
        $proximos = Registro::with(['evento.categoria'])
            ->where('user_id', $user->id)
            ->where('estado', 'INSCRITO')
            ->whereHas('evento', function ($q) {
                $q->where('fecha', '>=', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Eventos finalizados (ya pasaron, INSCRITO)
        $finalizados = Registro::with(['evento.categoria'])
            ->where('user_id', $user->id)
            ->where('estado', 'INSCRITO')
            ->whereHas('evento', function ($q) {
                $q->where('fecha', '<', now()->toDateString());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Inscripciones canceladas
        $cancelados = Registro::with(['evento.categoria'])
            ->where('user_id', $user->id)
            ->where('estado', 'CANCELADO')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('estudiante.eventos.mis', compact('proximos', 'finalizados', 'cancelados'));
    }



}
