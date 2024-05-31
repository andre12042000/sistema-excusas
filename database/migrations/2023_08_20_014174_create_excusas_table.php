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
        Schema::create('excusas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->unsignedBigInteger('estudiante_id');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');
            $table->date('fecha_inicial')->nullable();
            $table->date('fecha_final')->nullable();
            $table->string('grado');
            $table->string('horas')->nullable();
            $table->string('motivo');
            $table->string('motivo_descripcion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('firma')->nullable();
            $table->string('soporte_excusa')->nullable();
            $table->string('observaciones')->nullable();
            $table->enum('tecnica',['SI','NO'])->default('NO');
            $table->enum('status',['APROVADO','RECHAZADO', 'REGISTRADO'])->default('REGISTRADO');
            $table->enum('tipo',['SALIDA','EXCUSA'])->default('EXCUSA');
            $table->string('minutos')->nullable();
            $table->string('hora_exacta')->nullable();
            $table->enum('primera_hora',['SI','NO'])->default('NO')->nullable();
            $table->enum('segunda_hora',['SI','NO'])->default('NO')->nullable();
            $table->enum('tercera_hora',['SI','NO'])->default('NO')->nullable();
            $table->enum('cuarta_hora',['SI','NO'])->default('NO')->nullable();
            $table->enum('quinta_hora',['SI','NO'])->default('NO')->nullable();
            $table->enum('sexta_hora',['SI','NO'])->default('NO')->nullable();
            $table->enum('septima_hora',['SI','NO'])->default('NO')->nullable();
            $table->unsignedBigInteger('padre_id');
            $table->foreign('padre_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excusas');
    }
};
