<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentario';

    protected $primaryKey = 'id_comentario';

    protected $fillable = [
        'id_negocio',
        'id_cliente',
        'descripcion',
        'fecha_creacion',
    ];

    public $timestamps = false;
}