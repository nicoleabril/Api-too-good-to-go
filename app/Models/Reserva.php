<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reserva';

    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'id_negocio',
        'id_cliente',
        'metodo_pago',
        'fecha',
        'hora_minima',
        'hora_maxima',
        'estado',
        'nombres',
        'apellidos',
        'correo_electronico',
        'telefono',
    ];

    public $timestamps = false;
}