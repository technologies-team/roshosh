<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\Auth\VendorController;
use App\Services\EmailService;
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
Route::get('/send-notification', [PushNotificationController::class, 'sendPushNotification']);
/**
 * @param $controller
 * @return void
 */
function Costumer($controller): void
{
    Route::prefix('/auth')->group(function () use ($controller) {

        Route::post('/reset-password', [EmailController::class, 'resetPassword']);
        Route::post("/reset-password/confirm", [EmailController::class, 'confirmResetPassword']);
        Route::post("/reset-password/check-otp", [EmailController::class, 'checkOtp']);
        Route::post('/login', [$controller, 'login']);
        Route::post('/social-login', [$controller, 'socialLogin']);
        Route::post('/phone-login', [$controller, 'phoneLogin']);
        Route::post('/register', [$controller, 'register']);

        Route::middleware('auth:sanctum')->group(function () use ($controller) {
            Route::put('/user/{id}', [UserController::class, 'update']);
            Route::get('/me', [$controller, 'me']);
            Route::get('/verify', [$controller, 'verify']);
            Route::get('/delete', [UserController::class, 'delete']);
            Route::post('/logout', [$controller, 'logout']);
        });
    });
}

Costumer(CustomerController::class);
Route::prefix('/vendor')->group(function () {
    Costumer(VendorController::class);
});
Route::prefix('/customer')->group(function () {
    Costumer(CustomerController::class);
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
Route::prefix('/helper')->group(function () {

    Route::get('/model', [VehiclesController::class, 'models']);
});
Route::prefix('/user')->group(function () {

    Route::middleware('auth:sanctum')
        ->group(function () {
    Route::prefix('/cart')->group(function () {
        //
                Route::get('/{id}', [CartController::class, 'show']);
                Route::get('/', [CartController::class, 'index']);
                Route::post('/', [CartController::class, 'store']);
                Route::put('/{id}', [CartController::class, 'update']);
                Route::delete('/{id}', [CartController::class, 'destroy']);
            });

    Route::prefix('/vehicle')->group(function () {
        //
        Route::get('/', [VehiclesController::class, 'index']);
        Route::get('/{id}', [VehiclesController::class, 'show']);
        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::post('/', [VehiclesController::class, 'store']);
                Route::put('/{id}', [VehiclesController::class, 'update']);
                Route::delete('/{id}', [VehiclesController::class, 'destroy']);
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
    Route::get('/calc-price/{id}/{offer_id}', [ServiceController::class, 'calcPrice']);

    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::post('/', [ServiceController::class, 'store']);
            Route::put('/{id}', [ServiceController::class, 'update']);
            Route::delete('/{id}', [ServiceController::class, 'destroy']);
        });
});

Route::prefix('/time')->group(function () {

    Route::post('/', [TimeController::class, 'index']);
});
Route::prefix('/home')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
});
Route::prefix('/contact')->group(function () {
    Route::get('/', [ContactController::class, 'index']);
    Route::get('/terms/{lang}', [ContactController::class, 'terms']);
    Route::get('/terms/', [ContactController::class, 'terms']);
            Route::post('/', [ContactController::class, 'store']);
            Route::put('/{id}', [ContactController::class, 'update']);
            Route::delete('/{id}', [ContactController::class, 'destroy']);
});
Route::prefix('/book')->group(function () {
    Route::middleware('auth:sanctum')
        ->group(function () {

            Route::get('/', [BookController::class, 'index']);
            Route::get('/{id}', [BookController::class, 'show']);
            Route::post('/', [BookController::class, 'store']);
            Route::put('/{id}', [BookController::class, 'update']);

        });
});
Route::prefix('/offers')->group(function () {
    Route::get('/', [OfferController::class, 'index']);

    Route::middleware('auth:sanctum')
        ->group(function () {

            Route::get('/{id}', [OfferController::class, 'show']);
            Route::post('/', [OfferController::class, 'store']);
            Route::patch('/{id}', [OfferController::class, 'update']);

        });
});
Route::prefix('/coupon')->group(function () {
    Route::middleware('auth:sanctum')
        ->group(function () {
            Route::post('/', [CouponController::class, 'apply']);
            Route::post('/remove', [CouponController::class, 'remove']);

        });
});

