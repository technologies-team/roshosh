<?php

use App\Http\Controllers\FirebaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});Route::get('/terms', function () {
    return view('terms');
});
;Route::get('/terms/en', function () {
    return view('terms');
});
Route::get('/terms/ar', function () {
    return view('terms_ar');
});
Route::get('firebase-phone-authentication', [FirebaseController::class, 'index']);
