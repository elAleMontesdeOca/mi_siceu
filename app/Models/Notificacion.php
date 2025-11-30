<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones'; // 👈 SOLUCIÓN

    protected $fillable = [
        'evento_id',
        'titulo',
        'mensaje',
        'fecha_envio',
        'tipo'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}
