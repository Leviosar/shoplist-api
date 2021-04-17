<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::post('/register', 'UserController@store');
Route::post('/token', 'UserController@sanctum');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', 'UserController@show');
});