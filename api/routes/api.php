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
Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('signup', ['as' => 'user.create', 'uses' => 'AuthController@register']);
Route::post('login', ['as' => 'user.login', 'uses' => 'AuthController@login']);

Route::group(['prefix' => 'auth', 'middleware' => 'jwt.auth'], function () {
    Route::post('logout', ['as' => 'user.logout', 'uses' => 'AuthController@logout']);
});

Route::group(['middleware' => ['jwt.auth', 'roles'], 'roles' => ['administrator']], function () {
    Route::resource('user', 'UserController', [
        'except' => ['create', 'edit']
    ]);
});

