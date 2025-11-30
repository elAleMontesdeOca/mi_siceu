<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Registro;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Para el QR
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// Para correos
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistroEventoMail;

class RegistroEventoController extends Controller
{
    public function store($id)
    {
        $user = Auth::user();
        $evento = Evento::findOrFail($id);

        // 1. Validar si el evento ya pasó
        if ($evento->fecha < now()->toDateString()) {
            return back()->with('error', 'Este evento ya no está disponible.');
        }

        // 2. Buscar si ya existe algún registro (INSCRITO o CANCELADO)
        $registro = Registro::where('user_id', $user->id)
            ->where('evento_id', $evento->id)
            ->first();

        // 2.1 Ya está inscrito
        if ($registro && $registro->estado === 'INSCRITO') {
            return back()->with('error', 'Ya estás inscrito en este evento.');
        }

        // 3. Validar cupo (solo contando INSCRITOS)
        $inscritos = Registro::where('evento_id', $evento->id)
            ->where('estado', 'INSCRITO')
            ->count();

        if ($inscritos >= $evento->cupo_max) {
            return back()->with('error', 'El cupo de este evento está lleno.');
        }

        // ========== 4. Si existía registro CANCELADO, reactivarlo ==========
        if ($registro && $registro->estado === 'CANCELADO') {

            $registro->estado = 'INSCRITO';
            $registro->fecha_registro = now();

            // Aseguramos que tenga token para QR
            if (!$registro->qr_token) {
                $registro->qr_token = hash('sha256', $registro->id . '-' . $registro->evento_id);
            }

            $registro->save();

            // Notificación interna
            Notificacion::create([
                'evento_id' => $evento->id,
                'titulo' => 'Inscripción reactivada',
                'mensaje' => "Tu inscripción al evento '{$evento->titulo}' ha sido reactivada.",
                'fecha_envio' => now(),
                'tipo' => 'informativa',
            ]);

            // Generar QR en BASE64 (SVG)
            $qrBase64 = $this->generarQrBase64($registro->qr_token);

            // Enviar correo con QR
            Mail::to($user->email)->send(
                new RegistroEventoMail($evento, $qrBase64)
            );

            return back()->with('success', 'Tu inscripción ha sido reactivada correctamente.');
        }

        // ========== 5. Crear registro nuevo ==========
        $registro = Registro::create([
            'user_id' => $user->id,
            'evento_id' => $evento->id,
            'estado' => 'INSCRITO',
            'fecha_registro' => now(), // si el campo existe en la tabla
        ]);

        // Generar y guardar token QR para este registro
        $registro->qr_token = hash('sha256', $registro->id . '-' . $registro->evento_id);
        $registro->save();

        // Notificación interna
        Notificacion::create([
            'evento_id' => $evento->id,
            'titulo' => 'Inscripción realizada',
            'mensaje' => "Te has inscrito al evento '{$evento->titulo}'.",
            'fecha_envio' => now(),
            'tipo' => 'informativa',
        ]);

        // Generar QR en BASE64 (SVG)
        $qrBase64 = $this->generarQrBase64($registro->qr_token);

        // Enviar correo con QR
        Mail::to($user->email)->send(
            new RegistroEventoMail($evento, $qrBase64)
        );

        return back()->with('success', 'Te has inscrito correctamente al evento.');
    }

    public function cancel($registroId, Request $request)
    {
        $user = Auth::user();

        $registro = Registro::where('id', $registroId)
            ->where('user_id', $user->id)
            ->where('estado', 'INSCRITO')
            ->firstOrFail();

        $registro->estado = 'CANCELADO';
        $registro->save();

        $evento = $registro->evento;

        // Notificación interna
        Notificacion::create([
            'evento_id' => $evento->id,
            'titulo' => 'Inscripción cancelada',
            'mensaje' => "Has cancelado tu inscripción al evento '{$evento->titulo}'.",
            'fecha_envio' => now(),
            'tipo' => 'informativa',
        ]);

        return back()->with('success', 'Tu inscripción ha sido cancelada. Puedes volver a inscribirte cuando quieras mientras el evento esté disponible.');
    }

    // ================== GENERACIÓN QR (SVG BASE64) ==================
    private function generarQrBase64(string $texto): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(300),          // tamaño del QR
            new SvgImageBackEnd()            // SVG puro (no necesita GD ni Imagick)
        );

        $writer = new Writer($renderer);

        // SVG en texto
        $svgString = $writer->writeString($texto);

        // Lo codificamos en Base64
        return base64_encode($svgString);
    }

    // Vista del QR para el estudiante (sigue igual)
    public function qr($id)
    {
        $user = Auth::user();

        // Aseguramos que el registro pertenezca al usuario logueado
        $registro = Registro::with('evento')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Por si existía el registro viejo sin token
        if (!$registro->qr_token) {
            $registro->qr_token = hash('sha256', $registro->id . '-' . $registro->evento_id);
            $registro->save();
        }

        // Generamos el QR en BASE64
        $qrBase64 = $this->generarQrBase64($registro->qr_token);

        return view('estudiante.qr', compact('registro', 'qrBase64'));
    }
}
