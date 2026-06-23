<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Momentos extends Model
{
    protected $fillable = [
        'titulo',
        'fecha',
        'descripcion',
        'foto'
    ];

}
