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


// Route::middleware(['auth:sanctum'])->group(function () {

    // ------------------------------ USUARIOS
    Route::get('/users', [AuthController::class, 'index']);
    Route::post('/users-create', [AuthController::class, 'store']);
    Route::get('/users-show/{id}', [AuthController::class, 'show']);
    Route::put('/users-update/{id}', [AuthController::class, 'update']);
    Route::delete('/users-destroy/{id}', [AuthController::class, 'destroy']);



    // ------------------------------ ROLES
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles-create', [RoleController::class, 'store']);
    Route::get('/roles-show/{id}', [RoleController::class, 'show']);
    Route::put('/roles-update/{id}', [RoleController::class, 'update']);
    Route::delete('/roles-destroy/{id}', [RoleController::class, 'destroy']);


    // ------------------------------- GASTOS
    Route::get('/gastos', [BillController::class, 'index']);
    Route::post('/gastos-create', [BillController::class, 'store']);
    Route::get('/gastos-show/{id}', [BillController::class, 'show']);
    Route::put('/gastos-update/{id}', [BillController::class, 'update']);
    Route::delete('/gastos-destroy/{id}', [BillController::class, 'destroy']);
    Route::get('/totalGastos', [BillController::class, 'totalGastos']);

    

    // ------------------------------ BANCOS
    Route::get('/banco', [BankController::class, 'index']);
    Route::post('/banco-create', [BankController::class, 'store']);
    Route::get('/banco-show/{id}', [BankController::class, 'show']);
    Route::put('/banco-update/{id}', [BankController::class, 'update']);
    Route::delete('/banco-destroy/{id}', [BankController::class, 'destroy']);


    // --------------------------------- INGRESOS
    Route::get('/ingresos', [RevenueController::class, 'index']);
    Route::post('/ingresos-create', [RevenueController::class, 'store']);
    Route::get('/ingresos-show/{id}', [RevenueController::class, 'show']);
    Route::put('/ingresos-update/{id}', [RevenueController::class, 'update']);
    Route::delete('/ingresos-destroy/{id}', [RevenueController::class, 'destroy']);
    Route::get('/totalGanancias', [RevenueController::class, 'totalGanancias']);
    Route::get('/totalGananciasBanco', [RevenueController::class, 'totalGananciasBanco']);



    // --------------------------------- CAJA CHICA
    Route::get('/caja_chica', [PettyCashController::class, 'index']);
    Route::post('/caja_chica-create', [PettyCashController::class, 'store']);
    Route::get('/caja_chica-show/{id}', [PettyCashController::class, 'show']);
    Route::put('/caja_chica-update/{id}', [PettyCashController::class, 'update']);
    Route::delete('/caja_chica-destroy/{id}', [PettyCashController::class, 'destroy']);

    // --------------------------------- ZONA
    Route::get('/zona', [ZoneController::class, 'index']);
    Route::post('/zona', [ZoneController::class, 'store']);
    Route::get('/zona/{id}', [ZoneController::class, 'show']);
    Route::put('/zona/{id}', [ZoneController::class, 'update']);
    Route::delete('/zona/{id}', [ZoneController::class, 'destroy']);

    // --------------------------------- EMPRESA
    Route::get('/empresa', [CompanyController::class, 'index']);
    Route::post('/empresa-create', [CompanyController::class, 'store']);
    Route::get('/empresa-show/{id}', [CompanyController::class, 'show']);
    Route::put('/empresa-update/{id}', [CompanyController::class, 'update']);
    Route::delete('/empresa-destroy/{id}', [CompanyController::class, 'destroy']);
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Gerente
    // Route::apiResource('average-earnings', AverageEarningController::class); //PROMEDIO GANACIAS
    // Route::apiResource('average-expenses', AverageExpenseController::class); //PROMEDIO GASTOS
