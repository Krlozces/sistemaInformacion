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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('recepcion_doc_referencia');
            $table->unsignedBigInteger('numero_oficio')->unique()->default(629);
            $table->dateTime('fecha_hora_infraccion');
            $table->dateTime('fecha_hora_extraccion');
            $table->unsignedBigInteger('extractor');
            $table->unsignedBigInteger('procesador')->nullable();
            $table->string('motivo');
            $table->string('conclusiones')->default('-');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('muestra_id');
            $table->foreign('muestra_id')->references('id')->on('muestras');
            $table->unsignedBigInteger('intervenido_id');
            $table->foreign('intervenido_id')->references('id')->on('intervenidos');
            $table->unsignedBigInteger('comisaria_id');
            $table->foreign( 'comisaria_id' )->references( 'id' )->on( 'comisarias' );
            $table->unsignedBigInteger('extraccion_id');
            $table->foreign( 'extraccion_id' )->references( 'id' )->on( 'extraccion' );
            $table->unsignedBigInteger('usuario_id');
            $table->foreign( 'usuario_id' )->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
