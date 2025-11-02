<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mediciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->enum('tipo_magnitud', ['tiempo', 'longitud', 'masa', 'velocidad', 'aceleracion', 'otra']);
            $table->string('unidad', 50);
            $table->json('valores'); // Array de mediciones
            $table->decimal('valor_verdadero', 15, 6)->nullable();
            $table->json('analisis_resultado')->nullable(); // Resultados del análisis
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

        Schema::create('propagaciones_incertidumbre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->enum('operacion', ['suma', 'resta', 'multiplicacion', 'division', 'potencia']);
            $table->json('variables'); // Variables con sus valores e incertidumbres
            $table->json('resultado'); // Resultado de la propagación
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propagaciones_incertidumbre');
        Schema::dropIfExists('mediciones');
    }
};