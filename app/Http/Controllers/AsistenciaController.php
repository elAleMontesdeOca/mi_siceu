<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    // Vista del lector QR
    public function scanner()
    {
        return view('admin.asistencias.scanner');
    }

    // Registrar asistencia desde QR
    public function registrar(Request $request)
    {
        $token = $request->token;

        $registro = Registro::where('qr_token', $token)->first();

        if (!$registro) {
            return response()->json([
                'status' => 'error',
                'message' => 'Código QR inválido o no registrado.'
            ], 404);
        }

        // Evitar asistencia duplicada
        if (Asistencia::where('registro_id', $registro->id)->exists()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'La asistencia ya había sido registrada.'
            ], 409);
        }

        Asistencia::create([
            'registro_id' => $registro->id,
            'evento_id' => $registro->evento_id,
            'fecha_asistencia' => now(),
            'confirmado_por' => Auth::id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Asistencia registrada correctamente.',
            'estudiante' => $registro->user->name,
            'evento' => $registro->evento->titulo,
        ]);
    }
}
