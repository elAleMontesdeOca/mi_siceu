<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // EVENTOS POR CATEGORÍA
        $categorias = Categoria::withCount('eventos')->get();
        $labelsCategorias = $categorias->pluck('nombre');
        $dataCategorias = $categorias->pluck('eventos_count');

        // EVENTOS POR MES
        $eventosPorMes = Evento::select(
                DB::raw("DATE_TRUNC('month', fecha) AS mes"),
                DB::raw("COUNT(*) AS total")
            )
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $labelsMes = $eventosPorMes->map(fn ($e) => date('M Y', strtotime($e->mes)));
        $dataMes = $eventosPorMes->pluck('total');

        // CUPOS POR CATEGORÍA
        $cupos = Categoria::leftJoin('eventos', 'categorias.id', '=', 'eventos.categoria_id')
            ->select('categorias.nombre', DB::raw('SUM(eventos.cupo_max) as cupo_total'))
            ->groupBy('categorias.nombre')
            ->get();

        $labelsCupo = $cupos->pluck('nombre');
        $dataCupo = $cupos->pluck('cupo_total')->map(fn($v) => $v ?? 0);

        // TOTALES
        $totalEventos = Evento::count();
        $totalCategorias = Categoria::count();
        $totalCupo = Evento::sum('cupo_max');

        // TOTAL DE ESTUDIANTES INSCRITOS
        $rolEstudiante = Role::where('nombre', 'Estudiante')->first();
        $totalEstudiantes = User::where('role_id', $rolEstudiante->id)->count();

        // RETORNO FINAL (SOLO UNO)
        return view('admin.dashboard', compact(
            'labelsCategorias',
            'dataCategorias',
            'labelsMes',
            'dataMes',
            'labelsCupo',
            'dataCupo',
            'totalEventos',
            'totalCategorias',
            'totalCupo',
            'totalEstudiantes'
        ));
    }
}
