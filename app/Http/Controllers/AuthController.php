<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        $users = User::with('role')->get();

        return response()->json([
            'status' => true,
            'data' => $users
        ], 200);
    }

    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $user
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Usuario actualizado correctamente',
            'data' => $user
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);


        return response()->json([
            [
                'data' => $user,
                'message' => 'Usuario creado correctamente',
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ]
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'Usuario eliminado correctamente'
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        $user = User::with('role')->where('email', $request->email)->first();

        return response()->json([
            [
                'status' => true,
                'message' => 'Usuario logeado correctamente',
                'data' => $user,
                'token' => $user->createToken('API Token')->plainTextToken
            ]
        ], 200);
    }
}
