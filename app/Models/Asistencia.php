<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'registro_id',
        'evento_id',
        'fecha_asistencia',
        'confirmado_por',
    ];

    /**
     * Relación con Registro
     */
    public function registro()
    {
        return $this->belongsTo(Registro::class);
    }

    /**
     * Relación con Evento
     */
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    /**
     * Usuario administrador que confirmó la asistencia
     */
    public function confirmadoPor()
    {
        return $this->belongsTo(User::class, 'confirmado_por');
    }
}
