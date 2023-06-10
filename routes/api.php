<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AverageEarningController;
use App\Http\Controllers\AverageExpenseController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PettyCashController;
use App\Http\Controllers\ZoneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('auth/login', [AuthController::class, 'login']); //INICIAR SESIÓN



Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('auth/register', [AuthController::class, 'create']); //CREAR USUARIOS

    Route::apiResource('roles', RoleController::class); //ROLES

    // ================================= GASTOS
    Route::apiResource('bills', BillController::class); //GASTOS
    Route::apiResource('average-expenses', AverageExpenseController::class); //PROMEDIO GASTOS

    // ================================= GANANCIAS
    Route::apiResource('banks', BankController::class); //BANCOS
    Route::apiResource('revenue', RevenueController::class); // GANACIAS
    Route::apiResource('average-earnings', AverageEarningController::class); //PROMEDIO GANACIAS

    // ================================= CAJA CHICA
    Route::apiResource('petty_cash', PettyCashController::class);
    Route::apiResource('zones', ZoneController::class);
    Route::apiResource('companies', CompanyController::class);


});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Gerente