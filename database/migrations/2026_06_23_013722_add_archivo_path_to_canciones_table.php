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
        Schema::table('canciones', function (Blueprint $table) {
            $table->string('archivo_path')->nullable()->after('descripcion');
            $table->string('url_original')->nullable()->change();
            $table->string('embed_url')->nullable()->change();
            $table->string('plataforma')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('canciones', function (Blueprint $table) {
            $table->dropColumn('archivo_path');
            $table->string('url_original')->nullable(false)->change();
            $table->string('embed_url')->nullable(false)->change();
            $table->string('plataforma')->nullable(false)->change();
        });
    }
};
