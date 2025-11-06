<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Oferta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfertaController extends Controller
{
    public function index()
    {
        $ofertas = Oferta::all();

        return response()->json(['ofertas' => $ofertas], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_negocio' => 'required|exists:negocio,id_negocio',
            'nombre_oferta' => 'required|string',
            'descripcion' => 'nullable|string',
            'imagen_oferta' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'precio' => 'required|numeric',
        ]);

        // Guardar la imagen en la carpeta pública
        $imagenUrl = null;
        if ($request->hasFile('imagen_oferta')) {
            $imagenNombre = $request->file('imagen_oferta')->store('imagenes_ofertas', 'public');
            $imagenUrl = Storage::disk('public')->url($imagenNombre); // Obtener la URL completa de la imagen
        }

        $oferta = Oferta::create([
            'id_negocio' => $request->id_negocio,
            'nombre_oferta' => $request->nombre_oferta,
            'descripcion' => $request->descripcion,
            'imagen_oferta' => $imagenUrl, // Guardar la URL de la imagen en el campo `imagen_oferta`
            'precio' => $request->precio,
        ]);

        return response()->json(['message' => 'Oferta creada correctamente', 'oferta' => $oferta], 201);
    }

    public function show($id_negocio)
    {
        // Recupera las ofertas para el negocio dado
        $ofertas = Oferta::where('id_negocio', $id_negocio)->get();

        // Devuelve una respuesta con las ofertas encontradas (puede ser una lista vacía)
        return response()->json([
            'message' => 'Ofertas obtenidas correctamente',
            'ofertas' => $ofertas
        ], 200);
    }

    public function showOferta($id_oferta)
    {
        $oferta = Oferta::find($id_oferta);

        if (!$oferta) {
            return response()->json(['message' => 'Oferta no encontrada'], 404);
        }

        return response()->json(['message' => 'Oferta obtenida correctamente', 'oferta' => $oferta], 200);
    }

    public function update(Request $request, $id)
{
    $oferta = Oferta::find($id);

    if (!$oferta) {
        return response()->json(['message' => 'Oferta no encontrada'], 404);
    }

    $request->validate([
        'nombre_oferta' => 'string',
        'descripcion' => 'nullable|string',
        'imagen_oferta' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'precio' => 'numeric',
    ]);

    if ($request->hasFile('imagen_oferta')) {
        // Eliminar la imagen anterior si existe
        if ($oferta->imagen_oferta) {
            Storage::disk('public')->delete($oferta->imagen_oferta);
        }
        // Guardar la nueva imagen en la carpeta pública
        $imagenNombre = $request->file('imagen_oferta')->store('imagenes_ofertas', 'public');
        $imagenUrl = Storage::disk('public')->url($imagenNombre); // Obtener la URL completa de la imagen
        $oferta->imagen_oferta = $imagenUrl; // Guardar la URL completa de la imagen
    }

    $oferta->id_negocio = $request->input('id_negocio', $oferta->id_negocio);
    $oferta->nombre_oferta = $request->input('nombre_oferta', $oferta->nombre_oferta);
    $oferta->descripcion = $request->input('descripcion', $oferta->descripcion);
    $oferta->precio = $request->input('precio', $oferta->precio);
    $oferta->save();

    return response()->json(['message' => 'Oferta actualizada correctamente', 'oferta' => $oferta], 200);
}


    public function destroy($id)
    {
        $oferta = Oferta::find($id);

        if (!$oferta) {
            return response()->json(['message' => 'Oferta no encontrada'], 404);
        }

        // Eliminar la imagen asociada si existe
        if ($oferta->imagen_oferta) {
            Storage::disk('public')->delete($oferta->imagen_oferta);
        }

        $oferta->delete();

        return response()->json(['message' => 'Oferta eliminada correctamente'], 200);
    }
}
