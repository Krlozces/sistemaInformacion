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
        Schema::create('licencias', function (Blueprint $table) {
            $table->id();
            $table->string('placa')->unique()->nullable();
            $table->string('vehiculo')->nullable();
            $table->string('categoria')->nullable();
            $table->string('licencia')->nullable();
            $table->unsignedBigInteger('intervenido_id');
            $table->unsignedBigInteger('clase_id');
            $table->foreign( 'intervenido_id' )->references( 'id' )->on( 'intervenidos' );
            $table->foreign( 'clase_id' )->references('id')->on( 'clases' );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencias');
    }
};
