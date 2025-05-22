<?php

namespace App\Http\Controllers;

use App\Models\Cesta;
use Illuminate\Http\Request;

class CestaController extends Controller
{
    /**
     * Mostrar todas las cestas.
     */
    public function index()
    {
        return response()->json(Cesta::with(['user', 'coche', 'kit', 'caja', 'modelo', 'motor'])->get());
    }

    /**
     * Crear una nueva cesta.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'coche_id' => 'required|exists:coches,id',
            'kit_id' => 'required|exists:kits,id',
            'caja_id' => 'required|exists:cajas,id',
            'modelo_id' => 'required|exists:modelos,id',
            'motor_id' => 'required|exists:motores,id',
            'precio_total' => 'required|numeric',
        ]);

        $cesta = Cesta::create($request->all());

        return response()->json(['message' => 'Cesta creada con éxito', 'cesta' => $cesta], 201);
    }

    /**
     * Mostrar una cesta específica.
     */
    public function show($id)
    {
        $cesta = Cesta::with(['user', 'coche', 'kit', 'caja', 'modelo', 'motor'])->findOrFail($id);
        return response()->json($cesta);
    }

    /**
     * Actualizar una cesta.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'precio_total' => 'sometimes|numeric',
        ]);

        $cesta = Cesta::findOrFail($id);
        $cesta->update($request->all());

        return response()->json(['message' => 'Cesta actualizada con éxito', 'cesta' => $cesta]);
    }

    /**
     * Eliminar una cesta.
     */
    public function destroy($id)
    {
        Cesta::findOrFail($id)->delete();
        return response()->json(['message' => 'Cesta eliminada con éxito']);
    }
}