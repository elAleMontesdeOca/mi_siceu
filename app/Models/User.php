<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'matricula',
        'role_id',
    ];

    /**
     * Los atributos que se ocultan en la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts para campos especiales.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * RELACIÓN IMPORTANTE:
     * Un usuario pertenece a un rol.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function registros()
    {
        return $this->hasMany(Registro::class);
    }

}
