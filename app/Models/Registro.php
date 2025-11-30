<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $fillable = [
        'user_id',
        'evento_id',
        'fecha_registro',
        'estado',
        'qr_token',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generar el qr_token automáticamente cuando se crea el registro
    protected static function boot()
    {
        parent::boot();

        static::created(function ($registro) {
            if (!$registro->qr_token) {
                $registro->qr_token = hash('sha256', $registro->id . '-' . $registro->evento_id);
                $registro->save();
            }
        });
    }
}
