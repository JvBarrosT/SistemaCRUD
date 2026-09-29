<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoridadeCertificadora extends Model
{
    protected $table = 'autoridade_certificadoras';

    protected $fillable = [
        'origem_id',
        'nome',
        'tipo',
        'telefone',
        'situacao',
        'atualizado_data',
        'atualizado_hora',
    ];

    public function n2s()
    {
        return $this->hasMany(AutoridadeCertificadoraN2::class, 'autoridade_certificadora_id');
    }
}