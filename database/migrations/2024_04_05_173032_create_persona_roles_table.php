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
        Schema::create('persona_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('rol_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona_roles');
    }
};
