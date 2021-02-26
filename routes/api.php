<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*Route::group(['middleware'=>'guest:api ', 'namespace'=>'API'], function (){
    Route::post('login', 'RegisterController@login');
    Route::post('register', 'RegisterController@register');
});

Route::group(['middleware'=>'auth:api', 'namespace'=>'API'], function (){
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('products', 'ProductController');
    Route::post('logout', 'RegisterController@logout');
});*/


