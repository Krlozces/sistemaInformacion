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
        Schema::create('muestras', function (Blueprint $table) {
            $table->id();
            $table->dateTime( 'fecha_muestra');
            $table->string('descripcion')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('resultado_cualitativo');
            $table->float('resultado_cuantitativo', 8, 2)->nullable();
            $table->time( 'hora_muestra');
            $table->unsignedBigInteger('metodo_id');
            $table->foreign( 'metodo_id')->references('id')->on( 'metodos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muestras');
    }
};
