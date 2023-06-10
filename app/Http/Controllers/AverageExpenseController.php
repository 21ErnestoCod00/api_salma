<?php

namespace App\Http\Controllers;

use App\Models\AverageExpense;
use Illuminate\Http\Request;

class AverageExpenseController extends Controller
{
    public function index()
    {
        $averageExpenses = AverageExpense::all();
        return response()->json($averageExpenses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'amount' => 'required',
        ]);

        $averageExpense = AverageExpense::create($request->all());
        return response()->json($averageExpense, 201);
    }

    public function show($id)
    {
        $averageExpense = AverageExpense::findOrFail($id);
        return response()->json($averageExpense);
    }

    public function update(Request $request, $id)
    {
        $averageExpense = AverageExpense::findOrFail($id);

        $request->validate([
            'year' => 'required',
            'amount' => 'required',
        ]);

        $averageExpense->update($request->all());
        return response()->json($averageExpense);
    }

    public function destroy($id)
    {
        $averageExpense = AverageExpense::findOrFail($id);
        $averageExpense->delete();
        return response()->json(null, 204);
    }
}
