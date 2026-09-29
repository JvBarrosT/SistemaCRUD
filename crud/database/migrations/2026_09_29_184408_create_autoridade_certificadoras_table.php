<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autoridade_certificadoras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origem_id')->unique();
            $table->string('nome');
            $table->string('tipo')->nullable();
            $table->string('telefone')->nullable();
            $table->integer('situacao')->nullable();
            $table->string('atualizado_data')->nullable();
            $table->string('atualizado_hora')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autoridade_certificadoras');
    }
};