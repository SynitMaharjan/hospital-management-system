<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json([
        'message' => 'Welcome to HMS API',
        'status' => 'success',
        'version' => '1.0'
    ]);
});

Route::apiResource('patients', PatientApiController::class);
  