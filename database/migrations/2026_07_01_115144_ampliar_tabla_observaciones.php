<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('observaciones', function (Blueprint $table) {
            $table->string('titulo_resumen')->nullable()->after('avance_id');
            $table->text('comentario_complemento')->nullable()->after('ruta_adjunto');
            $table->string('ruta_adjunto_complemento')->nullable()->after('comentario_complemento');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
