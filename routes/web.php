<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/categories','TestConsole\TestCategories@index');

Route::group(['middleware'=>'guest','prefix'=>'api', 'namespace'=>'API'], function (){
    Route::post('login', 'RegisterController@login');
    Route::post('register', 'RegisterController@register');
});

Route::group(['middleware'=>'auth','prefix'=>'api', 'namespace'=>'API'], function (){
    Route::apiResource('products', 'ProductController');
    Route::apiResource('categories', 'CategoryController');
    Route::get('products/categories/{id}', 'ProductController@getProductCategory');
    Route::post('logout', 'RegisterController@logout');
});

