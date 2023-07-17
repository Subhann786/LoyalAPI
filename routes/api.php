<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;

Route::post('/purchase', [PurchaseController::class, 'purchase']);
Route::post('/redeem', [PurchaseController::class, 'redeem']);

Route::controller(UserController::class)->group(function(){
    Route::post('login','login');
    Route::post('register','register');
});


Route::controller(ProductController::class)->group(function(){
    Route::get('index', 'index');
    Route::post('store' , 'store');
    Route::get('show/{id}', 'show');
    Route::put('update/{id}', 'update');
    Route::delete('delete/{id}' ,'delete'); 
});

Route::get('/eg', function () {
    return response()->json(['message' => 'Hy']);
});


