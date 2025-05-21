<?php

namespace App\Http\Controllers;

use App\Models\Coche;
use App\Models\Kit;
use App\Models\Caja;
use App\Models\Modelo;
use App\Models\Motor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CocheController extends Controller
{
    public function index()
    {
        $coches = Coche::with(['kit', 'caja', 'modelo', 'motor'])->get();
        return view('coches.index', compact('coches'));
    }

    public function create()
    {
        $kits = Kit::all();
        $cajas = Caja::all();
        $modelos = Modelo::all();
        $motores = Motor::all();

        return view('coches.create', compact('kits', 'cajas', 'modelos', 'motores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'kit_id' => 'required|exists:kits,id',
            'caja_id' => 'required|exists:cajas,id',
            'modelo_id' => 'required|exists:modelos,id',
            'motor_id' => 'required|exists:motores,id',
            'precio_basico' => 'required|numeric|min:0',
            'imagenes_ruta' => 'nullable|array',
            'imagenes_ruta.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $precio_basico = $request->precio_basico;
        $precio_total = round($precio_basico * 1.21, 2);

        // Guardar imágenes en `/storage/coches/`
        $imagenes_ruta = [];
        if ($request->hasFile('imagenes_ruta')) {
            foreach ($request->file('imagenes_ruta') as $imagen) {
                $rutaImagen = $imagen->store('coches', 'public');
                $imagenes_ruta[] = $rutaImagen;
            }
        }

        // Crear el coche en la base de datos
        $coche = Coche::create([
            'nombre' => $request->nombre,
            'kit_id' => $request->kit_id,
            'caja_id' => $request->caja_id,
            'modelo_id' => $request->modelo_id,
            'motor_id' => $request->motor_id,
            'precio_basico' => $precio_basico,
            'precio_total' => $precio_total,
            'imagenes_ruta' => $imagenes_ruta, // Laravel maneja automáticamente JSON en el modelo
        ]);

        return redirect()->route('coches.index')->with('success', 'Coche creado correctamente.');
    }

    public function show(Coche $coche)
    {
        return view('coches.show', compact('coche'));
    }

    public function edit(Coche $coche)
    {
        $kits = Kit::all();
        $cajas = Caja::all();
        $modelos = Modelo::all();
        $motores = Motor::all();

        return view('coches.edit', compact('coche', 'kits', 'cajas', 'modelos', 'motores'));
    }

    public function update(Request $request, Coche $coche)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'kit_id' => 'required|exists:kits,id',
            'caja_id' => 'required|exists:cajas,id',
            'modelo_id' => 'required|exists:modelos,id',
            'motor_id' => 'required|exists:motores,id',
            'precio_basico' => 'required|numeric|min:0',
            'imagenes_ruta' => 'nullable|array',
            'imagenes_ruta.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $precio_basico = $request->precio_basico;
        $precio_total = round($precio_basico * 1.21, 2);

        // Actualizar imágenes si se suben nuevas
        if ($request->hasFile('imagenes_ruta')) {
            // Borrar imágenes previas si existen
            if (!empty($coche->imagenes_ruta)) {
                foreach ($coche->imagenes_ruta as $imagen) {
                    Storage::disk('public')->delete($imagen);
                }
            }

            // Guardar nuevas imágenes
            $imagenes_ruta = [];
            foreach ($request->file('imagenes_ruta') as $imagen) {
                $rutaImagen = $imagen->store('coches', 'public');
                $imagenes_ruta[] = $rutaImagen;
            }

            // Actualiza la columna con imágenes correctamente formateadas
            $coche->update(['imagenes_ruta' => $imagenes_ruta]);
        }

        // Actualizar los demás campos del coche
        $coche->update([
            'nombre' => $request->nombre,
            'kit_id' => $request->kit_id,
            'caja_id' => $request->caja_id,
            'modelo_id' => $request->modelo_id,
            'motor_id' => $request->motor_id,
            'precio_basico' => $precio_basico,
            'precio_total' => $precio_total,
        ]);

        return redirect()->route('coches.index')->with('success', 'Coche actualizado correctamente.');
    }

    public function destroy(Coche $coche)
    {
        // Borrar las imágenes antes de eliminar el coche
        if (!empty($coche->imagenes_ruta)) {
            foreach ($coche->imagenes_ruta as $imagen) {
                Storage::disk('public')->delete($imagen);
            }
        }

        $coche->delete();

        return redirect()->route('coches.index')->with('success', 'Coche eliminado correctamente.');
    }
}