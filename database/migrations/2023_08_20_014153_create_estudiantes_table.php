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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('codigo')->unique();
            $table->string('grado');
            $table->enum('tecnica',['SI','NO'])->default('NO');
            $table->enum('ruta',['SI','NO'])->default('SI');
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
        Schema::dropIfExists('estudiantes');
    }
};
