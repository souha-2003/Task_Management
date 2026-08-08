<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return new UserResource($request->user());
        });
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('tasks', TaskApiController::class);
        Route::apiResource('categories', CategoryApiController::class);
        
        // User administration routes
        Route::get('users', [UserApiController::class, 'index']);
        Route::put('users/{user}', [UserApiController::class, 'update']);
    });
});
