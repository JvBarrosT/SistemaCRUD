<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autoridade_certificadora_n2s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('autoridade_certificadora_id')
                  ->constrained('autoridade_certificadoras')
                  ->cascadeOnDelete();
            $table->unsignedBigInteger('origem_id')->unique();
            $table->string('nome');
            $table->string('tipo')->nullable();
            $table->integer('situacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autoridade_certificadora_n2s');
    }
};