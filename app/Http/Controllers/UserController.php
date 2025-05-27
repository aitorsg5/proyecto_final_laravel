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
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!auth()->attempt($credentials)) {
        return response()->json(['error' => 'Credenciales incorrectas'], 401);
    }

    $usuario = auth()->user();

    // Crear un token personal para este usuario
    $token = $usuario->createToken('token_app')->plainTextToken;

    // Devolver usuario + token
    return response()->json([
        'user' => $usuario,
        'token' => $token,
    ]);
}

public function logout(Request $request)
{
    try {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    } catch (\Exception $e) {
        \Log::error('Logout error: ' . $e->getMessage());
        return response()->json(['error' => 'Error al cerrar sesión'], 500);
    }
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

public function update(Request $request)
{
    // Obtiene el usuario autenticado por el token
    $usuario = $request->user();

    if (!$usuario) {
        return response()->json(['error' => 'Usuario no autenticado'], 401);
    }

    // Validamos los datos recibidos
    $validatedData = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        // Aquí la validación debe ignorar el email del usuario actual
        'email' => 'sometimes|required|email|unique:users,email,' . $usuario->id,
        'password' => 'sometimes|required|min:6',
    ]);

    // Si se actualiza la contraseña, cifrarla
    if (isset($validatedData['password'])) {
        $validatedData['password'] = bcrypt($validatedData['password']);
    }

    // Actualizamos el usuario con los datos validados
    $usuario->update($validatedData);

    return response()->json($usuario);  // Retorna el usuario actualizado
}


}
