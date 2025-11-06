<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Productos_Reservados extends Model
{
    use HasFactory;

    protected $table = 'productos_reservados';

    protected $primaryKey = 'id_producto_reservado';

    protected $fillable = [
        'id_producto',
        'id_reserva',
        'id_negocio',
        'id_cliente',
        'cantidad',
        'tipo_producto',
    ];

    public $timestamps = false;
}