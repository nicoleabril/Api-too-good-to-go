<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    protected $table = 'oferta';

    protected $primaryKey = 'id_oferta';

    protected $fillable = [
        'id_negocio',
        'nombre_oferta',
        'descripcion',
        'imagen_oferta',
        'precio',
        'fecha_creacion',
    ];

    public $timestamps = false;
}

