<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';

    protected $primaryKey = 'id_venta';

    protected $fillable = [
        'id_reserva',
        'id_negocio',
        'id_producto',
        'id_cliente',
        'tipo_producto',
        'cantidad',
        'fecha_venta',
    ];

    public $timestamps = false;
}