<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\Console;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return response()->json(['message' => 'Lista de clientes obtenida correctamente', 'data' => $clientes], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ejemplo de validación para una imagen
            'id_cliente' => 'required|exists:usuario,id_usuario', // Validar que el id_cliente exista en la tabla usuario
        ]);

        // Guardar la foto_perfil en el servidor si es necesario
        $imagenUrl = null;
        if ($request->hasFile('foto_perfil')) {
            $imagenNombre = $request->file('foto_perfil')->store('imagenes_clientes', 'public');
            $imagenUrl = Storage::disk('public')->url($imagenNombre); // Obtener la URL completa de la imagen
        }

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'foto_perfil' => $imagenUrl,
            'id_cliente' => $request->id_cliente,
        ]);

        return response()->json(['message' => 'Cliente creado correctamente', 'data' => $cliente], 201);
    }
    
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        $data = [
            'nombre' => $cliente->nombre,
            'foto_perfil' => $cliente->foto_perfil,
            'id_cliente' => $cliente->id_cliente,
        ];

        return response()->json(['message' => 'Cliente obtenido correctamente', 'data' => $data], 200);
    }

    public function update(Request $request, $id)
    {   
        $cliente = Cliente::find($id);
        if (!$cliente) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        $request->validate([
            'nombre' => 'sometimes|string',
            'foto_perfil' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Permitir actualización opcional de imagen
            'id_cliente' => 'sometimes|exists:usuario,id_usuario', // Validar que el id_cliente exista en la tabla usuario
            'posicion_x' => 'sometimes|string',
            'posicion_y' => 'sometimes|string',
        ]);

        // Actualizar la imagen si se proporciona una nueva
        if ($request->hasFile('foto_perfil')) {
            // Eliminar la imagen anterior si existe
            if ($cliente->foto_perfil) {
                Storage::disk('public')->delete($cliente->foto_perfil);
            }
            // Guardar la nueva imagen en la carpeta pública
            $imagenUrl = $request->file('foto_perfil')->store('imagenes_clientes', 'public');
            $cliente->foto_perfil = Storage::disk('public')->url($imagenUrl);
        } 
        
        $cliente->id_cliente = $request->input('id_cliente', $cliente->id_cliente);
        $cliente->nombre = $request->input('nombre', $cliente->nombre);
        $cliente->posicion_x = $request->input('posicion_x', $cliente->posicion_x);
        $cliente->posicion_y = $request->input('posicion_y', $cliente->posicion_y);
        $cliente->save();

        return response()->json(['message' => 'Cliente actualizado correctamente', 'data' => $cliente], 200);
    }

    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['message' => 'Cliente no encontrado'], 404);
        }

        // Eliminar la imagen del perfil del cliente
        Storage::delete($cliente->foto_perfil);

        // Eliminar el cliente
        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente'], 200);
    }

}
