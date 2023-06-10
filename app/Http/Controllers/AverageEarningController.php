<?php

namespace App\Http\Controllers;

use App\Models\AverageEarning;
use Illuminate\Http\Request;

class AverageEarningController extends Controller
{
    public function index()
    {
        $averageEarnings = AverageEarning::all();
        return response()->json($averageEarnings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'amount' => 'required',
        ]);

        $averageEarning = AverageEarning::create($request->all());
        return response()->json($averageEarning, 201);
    }

    public function show($id)
    {
        $averageEarning = AverageEarning::findOrFail($id);
        return response()->json($averageEarning);
    }

    public function update(Request $request, $id)
    {
        $averageEarning = AverageEarning::findOrFail($id);

        $request->validate([
            'year' => 'required',
            'amount' => 'required',
        ]);

        $averageEarning->update($request->all());
        return response()->json($averageEarning);
    }

    public function destroy($id)
    {
        $averageEarning = AverageEarning::findOrFail($id);
        $averageEarning->delete();

        return response()->json(null, 204);
    }
}
