<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::all();

        return response()->json(['reservas' => $reservas], 200);
    }

    public function store(Request $request)
    { //funcion para crear una reserva
        $request->validate([
            'id_negocio' => 'required|exists:negocio,id_negocio',
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'metodo_pago' => 'required|string',
            'fecha' => 'required|date',
            'hora_minima' => 'required|string',
            'hora_maxima' => 'required|string',
            'estado' => 'required|string',
            'nombres' => 'required|string',
            'apellidos' => 'required|string',
            'correo_electronico' => 'required|email',
            'telefono' => 'required|string',
        ]);

        $reserva = Reserva::create([
            'id_negocio' => $request->id_negocio,
            'id_cliente' => $request->id_cliente,
            'metodo_pago' => $request->metodo_pago,
            'fecha' => $request->fecha,
            'hora_minima' => $request->hora_minima,
            'hora_maxima' => $request->hora_maxima,
            'estado' => $request->estado,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo_electronico' => $request->correo_electronico,
            'telefono' => $request->telefono,
        ]);

        return response()->json(['message' => 'Reserva creada correctamente', 'reserva' => $reserva], 201);
    }

    public function showReservaxNegocio($id_negocio)
    {
        $reservas = Reserva::where('id_negocio', $id_negocio)->get();

        if ($reservas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron reservas para este negocio', 'reservas' => []], 200);
        }

        return response()->json(['message' => 'Reservas obtenidas correctamente', 'reservas' => $reservas], 200);
    }
    public function showReservaxCliente($id_cliente)
    {
        $reservas = Reserva::where('id_cliente', $id_cliente)->get();
        if($reservas->isEmpty()){
            return response()->json(['message' => 'No se encontraron reservas para este cliente', 'reservas' => []], 200);
        }
        return response()->json(['message' => 'Reservas obtenidas correctamente', 'reservas' => $reservas], 200);
    }
    public function showReserva($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (is_null($reserva)) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        return response()->json(['message' => 'Reserva obtenida correctamente', 'reserva' => $reserva], 200);
    }

    //ahora en vez de eliminar la reserva se actualiza su estado a cancelado por lo que solo se necesita el id de la reserva
    public function updateCancel( $id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (is_null($reserva)) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $reserva->update([
            'estado' => 'Cancelado',
        ]);

        return response()->json(['message' => 'Reserva cancelada correctamente', 'reserva' => $reserva], 200);
    }

    //ahora solo se van a mostrar las reservas de los negocios donde el estado de la reserva sea pendiente
    public function showReservaxNegocioPendiente($id_negocio)
    {
        $reservas = Reserva::where('id_negocio', $id_negocio)->where('estado', 'Pendiente')->get();

        if ($reservas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron reservas pendientes para este negocio'], 404);
        }

        return response()->json(['message' => 'Reservas pendientes obtenidas correctamente', 'reservas' => $reservas], 200);
    }

    //ahora solo se van a mostrar las reservas de los negocios donde el estado de la reserva sea En Progreso
    public function showReservaxNegocioEnProgreso($id_negocio)
    {
        $reservas = Reserva::where('id_negocio', $id_negocio)->where('estado', 'En Proceso')->get();

        if ($reservas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron reservas en progreso para este negocio'], 404);
        }

        return response()->json(['message' => 'Reservas en progreso obtenidas correctamente', 'reservas' => $reservas], 200);
    }

    //ahora solo se van a mostrar las reservas de los negocios donde el estado de la reserva sea En Progreso
    public function showReservaxNegocioListas($id_negocio)
    {
        $reservas = Reserva::where('id_negocio', $id_negocio)->where('estado', 'Realizado')->get();

        if ($reservas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron reservas listas para este negocio'], 404);
        }

        return response()->json(['message' => 'Reservas listas obtenidas correctamente', 'reservas' => $reservas], 200);
    }
    //función para cambiar el estado a"En Proceso" recibiendo el id de la reserva
    public function updateEnProceso($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (is_null($reserva)) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $reserva->update([
            'estado' => 'En Proceso',
        ]);

        return response()->json(['message' => 'Reserva en progreso correctamente', 'reserva' => $reserva], 200);
    }
    //función para cambiar el estado  a "Finalizado sin Entrega" recibiendo el id de la reserva
    public function updateFinalizaSinEntrega($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (is_null($reserva)) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $reserva->update([
            'estado' => 'Realizado',
        ]);

        return response()->json(['message' => 'Reserva finalizada correctamente', 'reserva' => $reserva], 200);
    }
    //función para cambiar el estado a "Entregado" recibiendo el id de la reserva
    public function updateEntregado($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (is_null($reserva)) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $reserva->update([
            'estado' => 'Finalizado',
        ]);

        return response()->json(['message' => 'Reserva entregada correctamente', 'reserva' => $reserva], 200);
    }
    //función para cambiar el estado de la reserva a "Cancelado" recibiendo el id de la reserva
    public function updateCancelado($id_reserva)
    {
        $reserva = Reserva::find($id_reserva);

        if (is_null($reserva)) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }

        $reserva->update([
            'estado' => 'Cancelado',
        ]);

        return response()->json(['message' => 'Reserva cancelada correctamente', 'reserva' => $reserva], 200);
    }
}