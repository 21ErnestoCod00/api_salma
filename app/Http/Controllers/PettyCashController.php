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
        $zones = Zone::all();
        $companies = Company::all();

        return response()->json([
            'zones' => $zones,
            'companies' => $companies,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'month' => 'required|string',
            'day' => 'required|integer',
            'zone_id' => 'required|exists:zones,id',
            'reason' => 'required|string',
            'amount' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);

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
        $pettyCash = PettyCash::find($id);

        if (!$pettyCash) {
            return response()->json(['message' => 'Petty cash not found'], 404);
        }

        $validatedData = $request->validate([
            'month' => 'required|string',
            'day' => 'required|integer',
            'zone_id' => 'required|exists:zones,id',
            'reason' => 'required|string',
            'amount' => 'required|numeric',
            'company_id' => 'required|exists:companies,id',
        ]);

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
