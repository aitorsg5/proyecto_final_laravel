<?php

namespace App\Http\Controllers;

use App\Models\Kit;
use Illuminate\Http\Request;

class KitController extends Controller
{
    public function index()
    {
           return response()->json(Kit::all());

    }

    public function create()
    {
        return view('kits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'paquete' => 'required|in:economico,estandar,rs',
            'precio' => 'required|numeric',
        ]);

        Kit::create($request->all());

        return redirect()->route('kits.index')->with('success', 'Kit creado correctamente.');
    }

    public function show(string $id)
    {
        $kit = Kit::findOrFail($id);
        return view('kits.show', compact('kit'));
    }

    public function edit(string $id)
    {
        $kit = Kit::findOrFail($id);
        return view('kits.edit', compact('kit'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'paquete' => 'required|in:economico,estandar,rs',
            'precio' => 'required|numeric',
        ]);

        $kit = Kit::findOrFail($id);
        $kit->update($request->all());

        return redirect()->route('kits.index')->with('success', 'Kit actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $kit = Kit::findOrFail($id);
        $kit->delete();

        return redirect()->route('kits.index')->with('success', 'Kit eliminado correctamente.');
    }
}
