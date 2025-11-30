<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Categoria;
use App\Models\Registro;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Writer;

class EventoController extends Controller
{
    // LISTAR EVENTOS (ADMIN)
    public function index()
    {
        $eventos = Evento::with('categoria')
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        $categorias = Categoria::all(); // ← AGREGADO

        return view('admin.eventos.index', compact('eventos', 'categorias'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.eventos.create', compact('categorias'));
    }

    // GUARDAR EVENTO
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date|after:today',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'lugar' => 'required|string|max:255',
            'cupo_max' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Evento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'lugar' => $request->lugar,
            'cupo_max' => $request->cupo_max,
            'categoria_id' => $request->categoria_id,
            'usuario_creador_id' => Auth::id(),
        ]);

        return redirect()
            ->route('eventos.index')
            ->with('success', 'Evento creado correctamente.');
    }

    // FORMULARIO EDITAR
    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $categorias = Categoria::all();
        return view('admin.eventos.edit', compact('evento', 'categorias'));
    }

    // ACTUALIZAR EVENTO
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha' => 'required|date|after:today',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'lugar' => 'required|string|max:255',
            'cupo_max' => 'required|integer|min:1',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $evento = Evento::findOrFail($id);

        $evento->update($request->all());

        return redirect()
            ->route('eventos.index')
            ->with('modal_success', 'El evento fue actualizado correctamente.');
    }

    // ELIMINAR EVENTO
    public function destroy($id)
    {
        Evento::destroy($id);

        return redirect()
            ->route('eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }

    // ======================================================
    // 📌 SHOW — REPORTE COMPLETO DEL EVENTO
    // ======================================================
    public function show($id)
    {
        $evento = Evento::with('categoria')->findOrFail($id);

        // REGISTROS
        $inscritos = Registro::where('evento_id', $id)
            ->where('estado', 'inscrito')
            ->with('user')
            ->get();

        $cancelados = Registro::where('evento_id', $id)
            ->where('estado', 'cancelado')
            ->with('user')
            ->get();

        // ASISTENCIAS
        $asistencias = Asistencia::where('evento_id', $id)
            ->with('registro.user')
            ->get();

        // CONTADORES
        $totalInscritos = $inscritos->count();
        $totalAsistencias = $asistencias->count();
        $totalCancelados = $cancelados->count();
        $cupoMax = $evento->cupo_max;

        // PORCENTAJES
        $porcentajeOcupado = $cupoMax > 0
            ? round(($totalInscritos / $cupoMax) * 100, 2)
            : 0;

        $porcentajeAsistencia = $totalInscritos > 0
            ? round(($totalAsistencias / $totalInscritos) * 100, 2)
            : 0;

        return view('admin.eventos.show', compact(
            'evento',
            'inscritos',
            'cancelados',
            'asistencias',
            'totalInscritos',
            'totalAsistencias',
            'totalCancelados',
            'porcentajeOcupado',
            'porcentajeAsistencia'
        ));
    }

}
