<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Productos_Reservados;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Productos_ReservadosController extends Controller
{
    public function index()
    {
        $productos_reservados = Productos_Reservados::all();

        return response()->json(['productos_reservados' => $productos_reservados], 200);
    }

    public function store(Request $request)
    { //funcion para crear un producto reservado
        $request->validate([
            'id_producto' => 'required|exists:producto,id_producto',
            'id_reserva' => 'required|exists:reserva,id_reserva',
            'id_negocio' => 'required|exists:negocio,id_negocio',
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'cantidad' => 'required|numeric',
            'tipo_producto' => 'required|string',
        ]);

        $producto_reservado = Productos_Reservados::create([
            'id_producto' => $request->id_producto,
            'id_reserva' => $request->id_reserva,
            'id_negocio' => $request->id_negocio,
            'id_cliente' => $request->id_cliente,
            'cantidad' => $request->cantidad,
            'tipo_producto' => $request->tipo_producto,
        ]);

        return response()->json(['message' => 'Producto reservado creado correctamente', 'producto_reservado' => $producto_reservado], 201);
    }

    public function showProductoReservadoxNegocio($id_negocio)
    {
        $productos_reservados = Productos_Reservados::where('id_negocio', $id_negocio)->get();

        if ($productos_reservados->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos reservados para este negocio'], 404);
        }

        return response()->json(['message' => 'Productos reservados obtenidos correctamente', 'productos_reservados' => $productos_reservados], 200);
    }

    public function showProductoReservadoxReserva($id_reserva)
    {
        $productos_reservados = Productos_Reservados::where('id_reserva', $id_reserva)->get();

        if ($productos_reservados->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos reservados para esta reserva'], 404);
        }

        return response()->json(['message' => 'Productos reservados obtenidos correctamente', 'productos_reservados' => $productos_reservados], 200);
    }

    public function showProductoReservadoxCliente($id_cliente)
    {
        $productos_reservados = Productos_Reservados::where('id_cliente', $id_cliente)->get();

        if ($productos_reservados->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos reservados para este cliente'], 404);
        }

        return response()->json(['message' => 'Productos reservados obtenidos correctamente', 'productos_reservados' => $productos_reservados], 200);   }

    //función para mostrar un producto reservado por el id de un producto 
    public function showProductoReservadoxProducto($id_producto)
    {
        $productos_reservados = Productos_Reservados::where('id_producto', $id_producto)->get();

        if ($productos_reservados->isEmpty()) {
            return response()->json(['message' => 'No se encontraron productos reservados para este producto'], 404);
        }

        return response()->json(['message' => 'Productos reservados obtenidos correctamente', 'productos_reservados' => $productos_reservados], 200);
    }

  
}
