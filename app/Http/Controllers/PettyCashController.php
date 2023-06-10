<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PettyCash;
use App\Models\Zone;
use Illuminate\Http\Request;

class PettyCashController extends Controller
{
    public function index()
    {
        $pettyCashList = PettyCash::with('zone', 'company')->get();
        return response()->json($pettyCashList);
    }

    public function create()
    {
        // Obtener las zonas y las compañías para llenar los campos select del formulario
        $zones = Zone::all();
        $companies = Company::all();

        return response()->json([
            'zones' => $zones,
            'companies' => $companies,
        ]);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'month' => 'required|string',
            'day' => 'required|integer',
            'zone_id' => 'required|exists:zones,id',
            'reason' => 'required|string',
            'amount' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Crear una nueva instancia de PettyCash con los datos validados
        $pettyCash = PettyCash::create($validatedData);

        return response()->json($pettyCash, 201);
    }

    public function show($id)
    {
        $pettyCash = PettyCash::with('zone', 'company')->find($id);

        if (!$pettyCash) {
            return response()->json(['message' => 'Petty cash not found'], 404);
        }

        return response()->json($pettyCash);
    }

    public function update(Request $request, $id)
    {
        // Buscar el registro de PettyCash
        $pettyCash = PettyCash::find($id);

        if (!$pettyCash) {
            return response()->json(['message' => 'Petty cash not found'], 404);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'month' => 'required|string',
            'day' => 'required|integer',
            'zone_id' => 'required|exists:zones,id',
            'reason' => 'required|string',
            'amount' => 'required|numeric',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Actualizar los datos del registro
        $pettyCash->update($validatedData);

        return response()->json($pettyCash);
    }

    public function destroy($id)
    {
        $pettyCash = PettyCash::find($id);

        if (!$pettyCash) {
            return response()->json(['message' => 'Petty cash not found'], 404);
        }

        $pettyCash->delete();

        return response()->json(['message' => 'Petty cash deleted']);
    }
}
