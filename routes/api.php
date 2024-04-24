<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Public route, doesn't need authenticate
Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);

//Protected routes, require authenticate to access these routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products/{id}',[ProductController::class,'show']);
    Route::get('/products',[ProductController::class,'index']);
    Route::put('/products/{id}',[ProductController::class,'update']);
    Route::delete('/products/{id}',[ProductController::class,'delete']);
});
