<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Usuario con acceso completo al sistema',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Estudiante',
                'descripcion' => 'Usuario que se registra y asiste a eventos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
