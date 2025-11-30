<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Registro;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Response;

class ReporteAsistenciaController extends Controller
{
    // =======================
    // EXPORTAR CSV
    // =======================
    public function exportCsv($id)
    {
        $evento = Evento::findOrFail($id);

        $registros = Registro::with('user')
            ->where('evento_id', $id)
            ->get();

        $asistencias = Asistencia::where('evento_id', $id)->get();

        // Nombre del archivo
        $filename = 'reporte_evento_' . $evento->id . '.csv';

        // Encabezados CSV
        $csv = "NOMBRE,EMAIL,ESTADO,ASISTENCIA\n";

        foreach ($registros as $r) {
            $nombre = $r->user->name ?? 'N/A';
            $email = $r->user->email ?? 'N/A';
            $estado = strtoupper($r->estado);

            $asistio = $asistencias->contains('registro_id', $r->id) ? 'SI' : 'NO';

            $csv .= "$nombre,$email,$estado,$asistio\n";
        }

        return Response::make($csv, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ]);
    }


    // =======================
    // EXPORTAR PDF DOMPDF
    // =======================
    public function exportPdf($id)
    {
        $evento = Evento::with('categoria')->findOrFail($id);

        $inscritos = Registro::where('evento_id', $id)
            ->where('estado', 'inscrito')
            ->with('user')
            ->get();

        $cancelados = Registro::where('evento_id', $id)
            ->where('estado', 'cancelado')
            ->with('user')
            ->get();

        $asistencias = Asistencia::where('evento_id', $id)
            ->with('registro.user')
            ->get();

        // Conteos
        $totalInscritos = $inscritos->count();
        $totalAsistencias = $asistencias->count();
        $totalCancelados = $cancelados->count();
        $cupoMax = $evento->cupo_max;

        $porcentajeOcupado = $cupoMax > 0 ? round(($totalInscritos / $cupoMax) * 100, 2) : 0;
        $porcentajeAsistencia =
            $totalInscritos > 0 ? round(($totalAsistencias / $totalInscritos) * 100, 2) : 0;

        $data = compact(
            'evento',
            'inscritos',
            'cancelados',
            'asistencias',
            'totalInscritos',
            'totalAsistencias',
            'totalCancelados',
            'porcentajeOcupado',
            'porcentajeAsistencia'
        );

        $pdf = \PDF::loadView('admin.eventos.export_pdf', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->download('reporte_evento_' . $evento->id . '.pdf');
    }

}
