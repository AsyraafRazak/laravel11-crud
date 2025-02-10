<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("addemployee", [EmployeeApiController::class, 'store',]);
Route::get("getallemployee", [EmployeeApiController::class, 'getallemployee',]);
Route::put("updateemployee/{id}", [EmployeeApiController::class, 'updateemployee',]);
Route::delete("deleteemployee/{id}", [EmployeeApiController::class, 'deleteemployee',]);
