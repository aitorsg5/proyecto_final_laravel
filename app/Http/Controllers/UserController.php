<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
public function index()
{
    return response()->json(User::all());
}
public function login(Request $request)
{
    // Validamos las credenciales
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!auth()->attempt($credentials)) {
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }

    $usuario = auth()->user();
    return response()->json($usuario);
}

public function store(Request $request)
{
    // Validamos los datos recibidos
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ]);

    // Creamos el usuario con los datos validados
    $usuario = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']), // Cifra la contraseña
    ]);

    return response()->json($usuario, 201); // Código 201 indica que se creó correctamente
}

public function update(Request $request, $id)
{
    // Validamos los datos recibidos
    $validatedData = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|email|unique:users,email,' . $id,
        'password' => 'sometimes|required|min:6',
    ]);

    // Buscamos el usuario por ID
    $usuario = User::findOrFail($id);

    // Actualizamos el usuario con los datos validados
    $usuario->update($validatedData);

    return response()->json($usuario);  // Retorna el usuario actualizado
    }
}
