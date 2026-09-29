<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoridadeCertificadoraN2 extends Model
{
    protected $table = 'autoridade_certificadora_n2s';

    protected $fillable = [
        'autoridade_certificadora_id',
        'origem_id',
        'nome',
        'tipo',
        'situacao',
    ];

    public function ac()
    {
        return $this->belongsTo(AutoridadeCertificadora::class, 'autoridade_certificadora_id');
    }

    public function ars()
    {
        return $this->hasMany(AutoridadeRegistro::class, 'autoridade_certificadora_n2_id');
    }
}