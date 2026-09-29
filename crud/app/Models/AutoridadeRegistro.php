<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoridadeRegistro extends Model
{
    protected $table = 'autoridade_registros';

    protected $fillable = [
        'autoridade_certificadora_n2_id',
        'origem_id',
        'nome',
        'situacao',
    ];

    public function n2()
    {
        return $this->belongsTo(AutoridadeCertificadoraN2::class, 'autoridade_certificadora_n2_id');
    }
}