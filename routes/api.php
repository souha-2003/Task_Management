<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\NotificationApiController;
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
        Route::apiResource('tasks', TaskApiController::class)->names('api.tasks');
        Route::apiResource('categories', CategoryApiController::class)->names('api.categories');
        
        // User administration routes
        Route::get('users', [UserApiController::class, 'index']);
        Route::put('users/{user}', [UserApiController::class, 'update']);

        // Notifications routes
        Route::get('notifications', [NotificationApiController::class, 'index']);
        Route::get('notifications/history', [NotificationApiController::class, 'history']);
        Route::post('notifications/{id}/read', [NotificationApiController::class, 'markAsRead']);
        Route::post('notifications/read-all', [NotificationApiController::class, 'markAllAsRead']);
        Route::delete('notifications/clear-all', [NotificationApiController::class, 'clearAll']);
        Route::delete('notifications/{id}', [NotificationApiController::class, 'destroy']);
        Route::post('update-device-token', [NotificationApiController::class, 'updateDeviceToken']);
    });
});
