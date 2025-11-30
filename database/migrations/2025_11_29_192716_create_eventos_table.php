<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('eventos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        
        $table->date('fecha');                 // ← SOLO FECHA
        $table->time('hora_inicio');           // ← HORA DE INICIO
        $table->time('hora_fin');              // ← HORA DE FIN
        
        $table->string('lugar');
        $table->integer('cupo_max');

        $table->foreignId('categoria_id')->constrained('categorias');
        $table->foreignId('usuario_creador_id')->constrained('users');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
