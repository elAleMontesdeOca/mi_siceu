<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Evento;
use App\Models\Registro;
use App\Models\Notificacion;
use Carbon\Carbon;

// Correos
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordatorioEventoMail;

class EnviarRecordatoriosEventos extends Command
{
    protected $signature = 'eventos:recordatorios';
    protected $description = 'Enviar recordatorios automáticos 24 horas antes de cada evento';

    public function handle()
    {
        $mañana = Carbon::tomorrow()->toDateString();

        // 1. Buscar eventos que ocurren mañana
        $eventos = Evento::where('fecha', $mañana)->get();

        foreach ($eventos as $evento) {

            // 2. Obtener estudiantes inscritos (con relación user)
            $registros = Registro::where('evento_id', $evento->id)
                ->where('estado', 'INSCRITO')
                ->with('user')
                ->get();

            foreach ($registros as $inscrito) {

                // 3. Notificación interna en el sistema
                Notificacion::create([
                    'evento_id' => $evento->id,
                    'titulo' => 'Recordatorio: Tu evento es mañana',
                    'mensaje' => "El evento '{$evento->titulo}' se realiza mañana a las {$evento->hora_inicio}.",
                    'fecha_envio' => now(),
                    'tipo' => 'recordatorio',
                ]);

                // 4. Enviar correo (si el usuario existe y tiene email)
                if ($inscrito->user && $inscrito->user->email) {
                    Mail::to($inscrito->user->email)
                        ->send(new RecordatorioEventoMail($evento, $inscrito->user));
                }
            }
        }

        $this->info('Recordatorios enviados correctamente.');
    }
}
