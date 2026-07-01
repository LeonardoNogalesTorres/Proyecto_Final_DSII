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
        Schema::create('observaciones_complementos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('observacion_id'); // Relación con la revisión padre
            $table->text('comentario_complemento');
            $table->string('ruta_adjunto_complemento')->nullable();
            $table->timestamps();

            // Llave foránea para mantener la integridad
            $table->foreign('observacion_id')->references('id')->on('observaciones')->onDelete('cascade');
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
