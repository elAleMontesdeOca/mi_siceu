<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        DB::table('categorias')->insert([
            ['nombre' => 'Académico', 'descripcion' => 'Eventos relacionados al ámbito académico'],
            ['nombre' => 'Cultural',  'descripcion' => 'Eventos culturales y artísticos'],
            ['nombre' => 'Deportivo', 'descripcion' => 'Actividades deportivas y recreativas'],
        ]);
    }
}
