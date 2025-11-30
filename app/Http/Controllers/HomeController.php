<?php

namespace App\Http\Controllers;

use App\Models\Evento;

class HomeController extends Controller
{
    public function index()
    {
        // 🔵 Obtener los 3 eventos más próximos
        $eventosDestacados = Evento::orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->take(3)
            ->get();

        return view('home', compact('eventosDestacados'));
    }
}
