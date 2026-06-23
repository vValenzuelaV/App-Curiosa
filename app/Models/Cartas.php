<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cartas extends Model
{
    protected $fillable = [
        'titulo',
        'contenido',
        'fecha',
        'leida',
    ];

    public function respuestas()
    {
        return $this->hasMany(respuestas::class, 'carta_id');
    }
}
