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
Route::get('getcategories', 'CategoryController@get');
Route::get('getproducts', 'ProductController@get');
Route::post('filterbycategory', 'ProductController@filter');
Route::post('sortby', 'ProductController@sort');
Route::post('deleteproduct', 'ProductController@delete');
Route::post('createproduct', 'ProductController@store');
Route::post('upload', 'ProductController@uploadFile');
Route::post('showproduct', 'ProductController@show');
Route::post('updateproduct', 'ProductController@update');