<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function totalGastos(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $bills = Bill::select(DB::raw('COALESCE(SUM(amount), 0) as total_amount'))
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('date', '=', $year);
            })
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('date', '=', $month);
            })
            ->get();

        return response()->json($bills);
    }
}
