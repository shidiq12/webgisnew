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


Route::apiResources(['user' => 'API\UserController']);
Route::get('findUser', 'API\UserController@search');

Route::middleware('auth:api')->get('/wisatas', function (Request $request) {
    return $request->wisatas();
});
Route::apiResources(['wisata' => 'API\WisataController']);
Route::get('findWisata', 'API\WisataController@search');

//Route::post('api/admin/user', "UserController@store");