<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function create(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);


        return response()->json([
            'data' => $user,
            'message' => 'Usuario creado correctamente',
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ], 200);
    }
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verificar las credenciales del usuario
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        // Obtener el usuario autenticado
        $user = User::where('email', $request->email)->first();

        return response()->json([
            ['status' => true,
            'message' => 'Usuario logeado correctamente',
            'data' => $user,
            'token' => $user->createToken('API Token')->plainTextToken]
        ], 200);
    }
}
