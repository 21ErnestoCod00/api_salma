<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('users')->get();
        return response()->json($roles);
    }

    public function show($id)
    {
        $role = Role::with('users')->findOrFail($id);
        return response()->json($role);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        // Crear un nuevo rol
        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        return response()->json($role, 201);
    }

    public function update(Request $request, $id)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        // Buscar y actualizar el rol
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        return response()->json($role);
    }

    public function destroy($id)
    {
        // Buscar y eliminar el rol
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(null, 204);
    }
}
