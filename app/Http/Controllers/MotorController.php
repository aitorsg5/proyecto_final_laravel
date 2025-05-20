<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;

class MotorController extends Controller
{
    public function index()
    {
        return response()->json(Motor::all());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'motor' => 'required|string|max:255',
            'combustible' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'turbo' => 'sometimes|boolean',
            'cc' => 'required|integer',
        ]);

        $motor = Motor::create($validatedData);

        return response()->json($motor, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'motor' => 'sometimes|required|string|max:255',
            'combustible' => 'sometimes|required|string|max:255',
            'precio' => 'sometimes|required|numeric',
            'turbo' => 'sometimes|boolean',
            'cc' => 'sometimes|required|integer',
        ]);

        $motor = Motor::findOrFail($id);
        $motor->update($validatedData);

        return response()->json($motor);
    }

    public function destroy($id)
    {
        $motor = Motor::findOrFail($id);
        $motor->delete();

        return response()->json(null, 204);
    }
}
