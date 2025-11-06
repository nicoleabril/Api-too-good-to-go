<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();

        return response()->json(['ventas' => $ventas], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_reserva' => 'required|exists:reserva,id_reserva',
            'id_negocio' => 'required|exists:negocio,id_negocio',
            'id_producto' => 'required|exists:producto,id_producto',
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'tipo_producto' => 'required|string',
            'cantidad' => 'required|numeric',
            'fecha_venta' => 'required|date',
        ]);

        $venta = Venta::create([
            'id_reserva' => $request->id_reserva,
            'id_negocio' => $request->id_negocio,
            'id_producto' => $request->id_producto,
            'id_cliente' => $request->id_cliente,
            'tipo_producto' => $request->tipo_producto,
            'cantidad' => $request->cantidad,
            'fecha_venta' => $request->fecha_venta,
        ]);

        return response()->json(['message' => 'Venta creada correctamente', 'venta' => $venta], 201);
    }

    public function showVenta($id_venta)
    {
        $venta = Venta::find($id_venta);

        if (!$venta) {
            return response()->json(['message' => 'Venta no encontrada'], 404);
        }

        return response()->json(['message' => 'Venta obtenida correctamente', 'venta' => $venta], 200);
    }

    public function showVentaxCliente($id_cliente)
    {
        $ventas = Venta::where('id_cliente', $id_cliente)->get();

        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron ventas para este cliente'], 404);
        }

        return response()->json(['message' => 'Ventas obtenidas correctamente', 'ventas' => $ventas], 200);
    }

    public function showVentaxProducto($id_producto)
    {
        $ventas = Venta::where('id_producto', $id_producto)->get();

        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron ventas para este producto'], 404);
        }

        return response()->json(['message' => 'Ventas obtenidas correctamente', 'ventas' => $ventas], 200);
    }

    //mostramos la venta por negocio
    public function showVentaxNegocio($id_negocio)
    {
        $ventas = Venta::where('id_negocio', $id_negocio)->get();

        if ($ventas->isEmpty()) {
            return response()->json(['message' => 'No se encontraron ventas para este negocio'], 404);
        }

        return response()->json(['message' => 'Ventas obtenidas correctamente', 'ventas' => $ventas], 200);
    }

    public function productoNormalMasVendido($id_negocio)
    {
        $producto = DB::table('venta')
            ->select('producto.*', DB::raw('COUNT(venta.id_producto) as total'))
            ->join('producto', 'venta.id_producto', '=', 'producto.id_producto')
            ->where('venta.tipo_producto', 'Normal')
            ->where('venta.id_negocio', $id_negocio)
            ->groupBy('producto.id_producto')
            ->orderByDesc('total')
            ->first();

        return response()->json($producto);
    }

    public function productoOfertaMasVendida($id_negocio)
    {
    $producto = DB::table('venta')
        ->select('oferta.*', DB::raw('COUNT(venta.id_producto) as total'))
        ->join('oferta', 'venta.id_producto', '=', 'oferta.id_oferta')
        ->where('venta.tipo_producto', 'Oferta')
        ->where('venta.id_negocio', $id_negocio)
        ->groupBy('oferta.id_oferta')
        ->orderByDesc('total')
        ->first();

    return response()->json($producto);
    }

    public function totalClientes($id_negocio)
    {
        $totalClientes = DB::table('venta')
            ->where('id_negocio', $id_negocio)
            ->distinct('id_cliente')
            ->count('id_cliente');

        return response()->json([$totalClientes]);
    }

    public function totalCompras($id_negocio)
    {
    $totalCompras = DB::table('venta')
        ->where('id_negocio', $id_negocio)
        ->count();

    return response()->json([$totalCompras]);
    }

    public function totalGanado($id_negocio)
    {
        $totalGanado = DB::table('venta')
            ->join('producto', 'venta.id_producto', '=', 'producto.id_producto')
            ->where('venta.id_negocio', $id_negocio)
            ->sum(DB::raw('venta.cantidad * producto.precio'));

        return response()->json([$totalGanado]);
    }

    public function cantidadClientesPorMesAnio($id_negocio)
{
    $clientes = DB::table('venta')
        ->select(DB::raw('EXTRACT(YEAR FROM fecha_venta) AS anio, EXTRACT(MONTH FROM fecha_venta) AS mes, COUNT(id_cliente) AS cantidad_clientes'))
        ->where('id_negocio', $id_negocio)
        ->groupBy(DB::raw('EXTRACT(YEAR FROM fecha_venta), EXTRACT(MONTH FROM fecha_venta)'))
        ->orderByDesc(DB::raw('anio, mes'))
        ->get();

    return response()->json($clientes);
}


    public function totalOrdenadoPorMesAnio($id_negocio)
    {
        $ordenes = DB::table('venta')
            ->select(DB::raw('EXTRACT(YEAR FROM fecha_venta) AS anio, EXTRACT(MONTH FROM fecha_venta) AS mes, COUNT(id_venta) AS total_ordenes'))
            ->where('id_negocio', $id_negocio)
            ->groupBy(DB::raw('EXTRACT(YEAR FROM fecha_venta), EXTRACT(MONTH FROM fecha_venta)'))
            ->orderByDesc(DB::raw('anio, mes'))
            ->get();

        return response()->json($ordenes);
    }

    public function totalIngresoPorMesAnio($id_negocio)
    {
        $ingresos = DB::table('venta')
            ->join('producto', 'venta.id_producto', '=', 'producto.id_producto')
            ->select(DB::raw('EXTRACT(YEAR FROM venta.fecha_venta) AS anio, EXTRACT(MONTH FROM venta.fecha_venta) AS mes, SUM(venta.cantidad * producto.precio) AS total_ingreso'))
            ->where('venta.id_negocio', $id_negocio)
            ->groupBy(DB::raw('EXTRACT(YEAR FROM venta.fecha_venta), EXTRACT(MONTH FROM venta.fecha_venta)'))
            ->orderByDesc(DB::raw('anio, mes'))
            ->get();

        return response()->json($ingresos);
    }




}