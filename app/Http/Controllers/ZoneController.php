<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::all();
        return response()->json($zones);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $zone = Zone::create($validatedData);

        return response()->json($zone, 201);
    }

    public function show($id)
    {
        $zone = Zone::find($id);

        if (!$zone) {
            return response()->json(['message' => 'Zone not found'], 404);
        }

        return response()->json($zone);
    }

    public function update(Request $request, $id)
    {
        $zone = Zone::find($id);

        if (!$zone) {
            return response()->json(['message' => 'Zone not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $zone->update($validatedData);

        return response()->json($zone);
    }

    public function destroy($id)
    {
        $zone = Zone::find($id);

        if (!$zone) {
            return response()->json(['message' => 'Zone not found'], 404);
        }

        $zone->delete();

        return response()->json(['message' => 'Zone deleted']);
    }

}
