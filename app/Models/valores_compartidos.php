<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class valores_compartidos extends Model
{
    protected $fillable = [
        'titulo',
        'icono',
        'descripcion',
    ];
}
