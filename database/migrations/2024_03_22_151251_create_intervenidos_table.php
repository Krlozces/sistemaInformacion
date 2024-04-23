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
        Schema::create('intervenidos', function (Blueprint $table) {
            $table->id();
            $table->string('edad');
            $table->string('nacionalidad');
            $table->char('sexo', 1); // F o M
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references( 'id' )->on('personas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intervenidos');
    }
};
