<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'lugar',
        'cupo_max',
        'categoria_id',
        'usuario_creador_id',
    ];


    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }


    public function creador()
    {
        return $this->belongsTo(User::class, 'usuario_creador_id');
    }

    public function registros()
    {
        return $this->hasMany(Registro::class);
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class);
    }

}
