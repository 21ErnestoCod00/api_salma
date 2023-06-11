<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Revenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BankController extends Controller
{

    public function index(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $bankId = $request->input('bank_id');

        $revenues = Revenue::select('revenues.bank_id', 'banks.name','banks.slog', DB::raw('SUM(revenues.amount) as total_amount'))
            ->leftJoin('banks', 'banks.id', '=', 'revenues.bank_id')
            ->when($year, function ($query) use ($year) {
                return $query->whereYear('revenues.date', $year);
            })
            ->when($month, function ($query) use ($month) {
                return $query->whereMonth('revenues.date', $month);
            })
            ->when($bankId, function ($query) use ($bankId) {
                return $query->where('revenues.bank_id', $bankId);
            })
            ->groupBy('revenues.bank_id', 'banks.name', 'banks.name')
            ->get();

        return response()->json($revenues);
    }


    public function store(Request $request)
    {
        $bankData = $request->all();

        // Verifica si se envió una imagen
        if ($request->hasFile('slog')) {
            $image = $request->file('slog');

            // Genera un nombre único para la imagen
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Guarda la imagen en el directorio de almacenamiento
            $image->storeAs('public/banks', $imageName);

            // Asigna la ruta de la imagen al campo "slog"
            $bankData['slog'] = 'banks/' . $imageName;
        }

        $bank = Bank::create($bankData);
        return response()->json($bank, 201);
    }

    public function show($id)
    {
        $bank = Bank::findOrFail($id);
        return response()->json($bank);
    }
    public function update(Request $request, $id)
    {
        // Encuentra el registro de Bank por su ID
        $bank = Bank::findOrFail($id);

        // Valida los campos de la solicitud
        $request->validate([
            'name' => 'sometimes', // Hace que el campo 'name' sea opcional
            'slog' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
        ]);

        // Verifica si se envió una imagen
        if ($request->hasFile('slog')) {
            $image = $request->file('slog');

            // Genera un nombre único para la imagen
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Guarda la imagen en el directorio de almacenamiento
            $image->storeAs('public/banks', $imageName);

            // Asigna la ruta de la imagen al campo 'slog'
            $bank->slog = 'banks/' . $imageName;
        }

        // Actualiza el campo 'name' solo si se proporciona en la solicitud
        if ($request->has('name')) {
            $bank->name = $request->input('name');
        }

        // Guarda los cambios en el registro de Bank
        $bank->save();

        return response()->json([
            'success' => true,
            'message' => 'Registro de Bank actualizado correctamente',
            'data' => $bank,
        ], 200);
    }




    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        // Elimina la imagen asociada al banco
        Storage::disk('public')->delete($bank->slog);

        $bank->delete();
        return response()->json(null, 204);
    }
}
