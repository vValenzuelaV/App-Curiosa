<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dibujo extends Model
{
    protected $table = 'dibujos';

    protected $fillable = [
        'titulo',
        'imagen',
        'creado_por',
    ];
}
