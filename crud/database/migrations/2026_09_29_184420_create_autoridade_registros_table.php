<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autoridade_registros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('autoridade_certificadora_n2_id')
                  ->constrained('autoridade_certificadora_n2s')
                  ->cascadeOnDelete();
            $table->unsignedBigInteger('origem_id')->unique();
            $table->string('nome');
            $table->integer('situacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autoridade_registros');
    }
};