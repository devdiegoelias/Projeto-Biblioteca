<?php

use Illuminate\Http\Request;

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

Route::middleware('auth.token')->prefix('/v1')->group(function(){
	Route::get('products','Api\\ApiController@products');
	Route::get('categories', 'Api\\ApiController@categories');
	Route::post('save_categories', 'Api\\ApiController@categories');
});