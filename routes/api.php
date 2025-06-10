<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TimeLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTHENTICATION ROUTES
Route::get('/login', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'index']);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('timelogs', TimeLogController::class);

    // TimeLog Actions
    Route::post('/timelogs/{project_id}/start', [TimeLogController::class, 'start']);
    Route::post('/timelogs/{project_id}/end', [TimeLogController::class, 'end']);

    // Reports
    Route::get('/report', [ReportController::class, 'generate']);
    Route::get('/report/pdf', [ReportController::class, 'exportPDF']);
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Route not found or unauthorized.',
    ], 404);
});