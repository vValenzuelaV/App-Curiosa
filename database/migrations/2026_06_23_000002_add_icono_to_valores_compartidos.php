<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega el campo 'icono' a la tabla valores_compartidos.
     */
    public function up(): void
    {
        Schema::table('valores_compartidos', function (Blueprint $table) {
            $table->string('icono')->default('✦')->after('titulo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('valores_compartidos', function (Blueprint $table) {
            $table->dropColumn('icono');
        });
    }
};
