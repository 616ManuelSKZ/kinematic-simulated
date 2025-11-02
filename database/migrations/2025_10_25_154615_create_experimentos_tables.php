<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre');
            $table->enum('tipo', ['mru', 'mruv', 'parabolico']);
            $table->json('parametros');
            $table->json('resultados')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::create('datos_experimentales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experimento_id')->constrained('experimentos')->onDelete('cascade');
            $table->string('archivo_csv')->nullable();
            $table->json('datos');
            $table->decimal('error_rmse', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('datos_experimentales');
        Schema::dropIfExists('experimentos');
    }
};