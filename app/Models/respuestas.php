<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class respuestas extends Model
{
    protected $fillable = [
        'carta_id',
        'nombre',
        'comentario',
        'fecha'
    ];

    public function cartas()
    {
        return $this->belongsTo(Cartas::class, 'carta_id');
    }
}
