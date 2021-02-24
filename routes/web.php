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

Route::post('/api/sorting', 'API\SortingController@sorting');
Route::post('/api/search', 'API\SearchController@getProductCategory');

Route::group(['middleware'=>'guest','prefix'=>'api', 'namespace'=>'API'], function (){
    Route::post('login', 'RegisterController@login');
    Route::post('register', 'RegisterController@register');
});

Route::group(['middleware'=>'auth','prefix'=>'api', 'namespace'=>'API'], function (){
    Route::resource('products', 'ProductController');
    Route::resource('categories', 'CategoryController');
    Route::post('logout', 'RegisterController@logout');
});
