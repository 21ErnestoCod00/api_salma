<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\bill;
use Illuminate\Http\Request;

class BillController extends Controller
{

    // ========================================= GASTOS

    public function index()
    {
        // $bills = Bill::all();
        $bills = Bill::orderBy('date', 'desc')->get();
        return response()->json($bills);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $bill = Bill::create($request->all());
        return response()->json($bill, 201);
    }

    public function show($id)
    {
        $bill = Bill::findOrFail($id);
        return response()->json($bill);
    }

    public function update(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);

        $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $bill->update($request->all());
        return response()->json($bill);
    }

    public function destroy($id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();
        return response()->json(null, 204);
    }
}
