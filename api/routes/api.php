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


//Resources e rotas exclusivos para ADM
Route::group(['middleware' => ['jwt.auth', 'roles'],'roles' => ['administrador']], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::delete('/{id}', ['as' => 'user.destroy', 'uses' => 'UserController@destroy']);
    });

    Route::resource('store', 'StoreController', ['except' => ['create', 'edit', 'index']]);
});

//Resources e rotas exclusivos para ADM e VENDEDORES
Route::group(['middleware' => ['jwt.auth', 'roles'],'roles' => ['administrador', 'vendedor']], function () {
    Route::delete('store-user/{user_id}/{store_id}', ['as' => 'store.user.destroy', 'uses' => 'StoreUserController@destroy']);
    Route::get('store', ['as' => 'store.index', 'uses' => 'StoreController@index']);
    Route::resource('store-user', 'StoreUserController', ['except' => ['create', 'edit', 'destroy']]);
});

//TODO melhorar esse esquema de permissoes
//Rotas que necessitam apenas estar autenticadas
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::put('user/{id}', ['as' => 'user.update', 'uses' => 'UserController@update']);
    Route::get('user/{id}', ['as' => 'user.show', 'uses' => 'UserController@show']);
    Route::get('user/', ['as' => 'user.index', 'uses' => 'UserController@index']);
    Route::post('auth/logout', ['as' => 'user.logout', 'uses' => 'AuthController@logout']);

});


