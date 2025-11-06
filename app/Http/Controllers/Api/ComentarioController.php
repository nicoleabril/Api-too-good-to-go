<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComentarioController extends Controller
{
    public function index()
    {
        $comentarios = Comentario::all();

        return response()->json(['comentarios' => $comentarios], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_negocio' => 'required|exists:negocio,id_negocio',
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'descripcion' => 'required|string',
        ]);

        $comentario = Comentario::create([
            'id_negocio' => $request->id_negocio,
            'id_cliente' => $request->id_cliente,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => date('Y-m-d H:i:s'),
        ]);

        return response()->json(['message' => 'Comentario creado correctamente', 'comentario' => $comentario], 201);
    }

    public function showComentarioxNegocio($id_negocio)
    {
        $comentarios = Comentario::where('id_negocio', $id_negocio)->get();

        if ($comentarios->isEmpty()) {
            return response()->json(['message' => 'No se encontraron comentarios para este negocio', 'comentarios' => 0 ], 200);
        }

        return response()->json(['message' => 'Comentarios obtenidos correctamente', 'comentarios' => $comentarios], 200);
    }
    public function showComentarioxCliente($id_cliente)
    {
        $comentarios = Comentario::where('id_cliente', $id_cliente)->get();

        if ($comentarios->isEmpty()) {
            return response()->json(['message' => 'No se encontraron comentarios para este cliente'], 404);
        }

        return response()->json(['message' => 'Comentarios obtenidos correctamente', 'comentarios' => $comentarios], 200);
    }

    public function showComentario($id_comentario)
    {
        $comentario = Comentario::find($id_comentario);

        if (is_null($comentario)) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        return response()->json(['message' => 'Comentario obtenido correctamente', 'comentario' => $comentario], 200);
    }

    public function update(Request $request, $id_comentario)
    {
        $comentario = Comentario::find($id_comentario);

        if (is_null($comentario)) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $request->validate([
            'descripcion' => 'required|string',
        ]);

        $comentario->descripcion = $request->descripcion;
        $comentario->save();

        return response()->json(['message' => 'Comentario actualizado correctamente', 'comentario' => $comentario], 200);
    }

    public function destroy($id_comentario)
    {
        $comentario = Comentario::find($id_comentario);

        if (is_null($comentario)) {
            return response()->json(['message' => 'Comentario no encontrado'], 404);
        }

        $comentario->delete();

        return response()->json(['message' => 'Comentario eliminado correctamente'], 200);
    }
}