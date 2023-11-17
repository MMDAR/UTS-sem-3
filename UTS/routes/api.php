<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\AuthController;

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

//method get
Route::get('/employees', [EmployeesController::class, 'index']);

//method post
Route::post('/employees', [EmployeesController::class, 'store']);

//method put
Route::put('/employees/{id}', [EmployeesController::class, 'update']);

//method delete
Route::delete('/employees/{id}', [EmployeesController::class, 'destroy']);

// menampilkan detail resource
Route::get('employees/{id}', [EmployeesController::class, 'show']);

// mencari karyawand dengan nama
Route::get('search', [EmployeesController::class, 'search']);

// Menampilkan employees aktif
Route::get('/active-employees', [EmployeesController::class, 'active']);

// Menampilkan employees tidak aktif
Route::get('/inactive-employees', [EmployeesController::class, 'inactive']);

// Menampilkan employees terminated
Route::get('/termin-employees', [EmployeesController::class, 'terminated']);

// register akun
Route::post('/register', [AuthController::class, 'register']);

// login akun
Route::post('/login', [AuthController::class, 'login']);

// middleware
Route::get('/employees', [EmployeesController::class, 'index'])->middleware('auth:sanctum');
