<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();

    // $user->token
});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('/auth')->group(function () {

    //
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/user/{id}', [UserController::class, 'update']);

        Route::get('/me', [AuthController::class, 'me']);
        Route::get('/delete', [UserController::class, 'delete']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('/attachment')->group(function () {
    //
    Route::get('/', [AttachmentController::class, 'index']);
    Route::get('/{id}', [AttachmentController::class, 'show']);
    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::post('/', [AttachmentController::class, 'store']);
            Route::put('/{id}', [AttachmentController::class, 'update']);
            Route::delete('/{id}', [AttachmentController::class, 'destroy']);
        });
    Route::get('/download/{name}',  [AttachmentController::class, 'download']);
});
Route::prefix('/banner')->group(function () {
    //
    Route::get('/', [BannerController::class, 'index']);
    Route::get('/{id}', [BannerController::class, 'show']);
    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::post('/', [BannerController::class, 'store']);
            Route::put('/{id}', [BannerController::class, 'update']);
            Route::delete('/{id}', [BannerController::class, 'destroy']);
        });
});
Route::prefix('/user')->group(function () {
    Route::prefix('/cart')->group(function () {
        //
        Route::get('/', [CartController::class, 'index']);
        Route::get('/{id}', [CartController::class, 'show']);
        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::post('/', [CartController::class, 'store']);
                Route::put('/{id}', [CartController::class, 'update']);
                Route::delete('/{id}', [CartController::class, 'destroy']);
            });
    });
    Route::prefix('/vehicle')->group(function () {
        //
        Route::get('/', [vehiclesController::class, 'index']);
        Route::get('/{id}', [vehiclesController::class, 'show']);
        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::post('/', [vehiclesController::class, 'store']);
                Route::put('/{id}', [vehiclesController::class, 'update']);
                Route::delete('/{id}', [vehiclesController::class, 'destroy']);
            });
    });
    Route::prefix('/location')->group(function () {
        //
        Route::get('/', [LocationController::class, 'index']);
        Route::get('/{id}', [LocationController::class, 'show']);
        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::post('/', [LocationController::class, 'store']);
                Route::put('/{id}', [LocationController::class, 'update']);
                Route::delete('/{id}', [LocationController::class, 'destroy']);
            });
    });
});

Route::prefix('/categories')->group(function () {
    //
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{id}', [CategoryController::class, 'show']);

    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'destroy']);
        });
});
Route::prefix('/service')->group(function () {
    Route::get('/', [ServiceController::class, 'index']);
    Route::get('/{id}', [ServiceController::class, 'show']);
    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::post('/', [ServiceController::class, 'store']);
            Route::put('/{id}', [ServiceController::class, 'update']);
            Route::delete('/{id}', [ServiceController::class, 'destroy']);
        });
});
