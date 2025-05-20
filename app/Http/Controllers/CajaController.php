<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index()
    {
        $cajas = Caja::all();
        return view('cajas.index', compact('cajas'));
    }

    public function create()
    {
        return view('cajas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'traccion' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        Caja::create($request->all());

        return redirect()->route('cajas.index')->with('success', 'Caja creada correctamente.');
    }

    public function show(string $id)
    {
        $caja = Caja::findOrFail($id);
        return view('cajas.show', compact('caja'));
    }

    public function edit(string $id)
    {
        $caja = Caja::findOrFail($id);
        return view('cajas.edit', compact('caja'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tipo' => 'required|string|max:255',
            'traccion' => 'required|string|max:255',
            'precio' => 'required|numeric',
        ]);

        $caja = Caja::findOrFail($id);
        $caja->update($request->all());

        return redirect()->route('cajas.index')->with('success', 'Caja actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $caja = Caja::findOrFail($id);
        $caja->delete();

        return redirect()->route('cajas.index')->with('success', 'Caja eliminada correctamente.');
    }
}
