<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileApiController;

use function PHPUnit\Framework\isEmpty;

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

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('/handling', MobileApiController::class)->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return response()->json([
        'status' => true,
        'message' => 'Berhasil mendapatkan data user',
        'data' => $request->user(),
    ], 200);
})->middleware('auth:sanctum');
