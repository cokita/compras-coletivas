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
Route::group(['middleware' => ['auth:api', 'roles'],'roles' => ['administrador']], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::delete('/{id}', ['as' => 'user.destroy', 'uses' => 'UserController@destroy']);
    });

    Route::resource('store', 'StoreController', ['except' => ['create', 'edit', 'index']]);
});

//Resources e rotas exclusivos para ADM e VENDEDORES
Route::group(['middleware' => ['auth:api', 'roles'],'roles' => ['administrador', 'vendedor']], function () {
    Route::delete('store-user/{user_id}/{store_id}', ['as' => 'store.user.destroy', 'uses' => 'StoreUserController@destroy']);
    Route::resource('store-user', 'StoreUserController', ['only' => ['update', 'store']]);
    Route::resource('order-type', 'OrderTypeController', ['only' => ['update', 'store', 'destroy']]);
    Route::resource('orders', 'OrdersController', ['only' => ['update', 'store', 'destroy']]);

});


//Rotas que necessitam apenas estar autenticadas
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('auth/logout', ['as' => 'user.logout', 'uses' => 'AuthController@logout']);
    Route::resource('order-type', 'OrderTypeController', ['only' => ['show', 'index']]);
    Route::resource('user', 'UserController', ['only' => ['show', 'index', 'update']]);
    Route::resource('store', 'StoreController', ['only' => ['show', 'index']]);
    Route::resource('orders', 'OrdersController', ['only' => ['show', 'index']]);
    Route::resource('order-catalog', 'OrderCatalogController');

});


