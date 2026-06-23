<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dibujos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->longText('imagen'); // Base64 PNG del canvas
            $table->string('creado_por');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dibujos');
    }
};
