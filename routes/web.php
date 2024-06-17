<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>'api'],function($routes){
    Route::post('/registerr',[UserController::class,'registerr']);
    });
