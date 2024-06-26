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
        Schema::create('personal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id');
            $table->foreign( 'persona_id' )->references( 'id' )->on( 'personas' );
            $table->char( 'genero', 1); // F o M
            $table->unsignedBigInteger('grado_id');
            $table->foreign('grado_id')->references('id')->on('grados');
            $table->string('unidad_perteneciente');
            $table->string('area_perteneciente');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('usuario');
            $table->string( 'password' );
            $table->unsignedBigInteger('certificado_id');
            $table->foreign('certificado_id')->references('id')->on('certificados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal');
    }
};
