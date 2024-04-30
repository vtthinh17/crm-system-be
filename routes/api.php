<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Public route, doesn't need authenticate
Route::post('login',[UserController::class,'login']);
Route::post('register',[UserController::class,'register']);
//-----------

Route::post('/products',[ProductController::class,'store']);






//Protected routes, require authenticate to access these routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products',[ProductController::class,'index']);
    Route::get('/products/{id}',[ProductController::class,'show']);
    Route::post('/products/getProductByCategory',[ProductController::class,'getProductByCategory']);
    Route::put('/products/{id}',[ProductController::class,'update']);
    Route::delete('/products/{id}',[ProductController::class,'delete']);
});
