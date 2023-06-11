<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{

    // ========================================= GANANCIAS

    public function index()
    {
        $Revenues = Revenue::with('bank')->orderBy('date', 'desc')->get();
        return response()->json($Revenues);
    }

    public function store(Request $request)
    {
        $RevenueData = $request->all();
        $bankId = $RevenueData['bank_id'];
        $bank = Bank::findOrFail($bankId);

        $Revenue = new Revenue();
        $Revenue->description = $RevenueData['description'];
        $Revenue->amount = $RevenueData['amount'];
        $Revenue->date = $RevenueData['date'];

        $bank->revenues()->save($Revenue);


        return response()->json([
            'status' => true,
            'message' => 'Creado correctamente',
            'data' => $Revenue,
        ], 201);
    }

    
    public function show($id)
    {
        $Revenue = Revenue::with('bank')->findOrFail($id);
        return response()->json($Revenue);
    }

    public function update(Request $request, $id)
    {
        $Revenue = Revenue::findOrFail($id);
        $Revenue->description = $request->input('description');
        $Revenue->amount = $request->input('amount');
        $Revenue->date = $request->input('date');
        $Revenue->save();

        return response()->json($Revenue, 200);
    }

    public function destroy($id)
    {
        $Revenue = Revenue::findOrFail($id);
        $Revenue->delete();

        return response()->json(null, 204);
    }


    public function totalGanancias(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $bills = Revenue::select(DB::raw('COALESCE(SUM(amount), 0) as total_amount'))
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('date', '=', $year);
            })
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('date', '=', $month);
            })
            ->get();

        return response()->json($bills);
    }

    public function totalGananciasBanco(Request $request)
{
    $bankId = $request->input('bank_id');

    $bills = Revenue::select(DB::raw('COALESCE(SUM(amount), 0) as total_amount'))
        ->where('bank_id', $bankId)
        ->get();

    return response()->json($bills);
}

}
