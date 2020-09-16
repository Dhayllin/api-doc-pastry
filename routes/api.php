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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');

Route::group([
    'middleware' => 'apiJwt',
], function ($router) {

    Route::get('users','UserController@index');
    Route::post('users/store','UserController@store');
    Route::get('users/{idUsers}','UserController@show');
    Route::get('users/{idUser}/edit','UserController@edit');
    Route::post('users/update/{id}','UserController@update');
    Route::delete('users/{id}','UserController@destroy');

    Route::get('customers','CustomerController@index');
    Route::post('customers/store','CustomerController@store');
    Route::get('customers/{idCustomer}','CustomerController@show');
    Route::get('customers/{idCustomer}/edit','CustomerController@edit');
    Route::post('customers/update/{idCustomer}','CustomerController@update');
    Route::delete('customers/{id}','CustomerController@destroy');

    Route::get('products','ProductController@index');
    Route::post('products/store','ProductController@store');
    Route::get('products/{idProduct}','ProductController@show');
    Route::post('products/update/{id}','ProductController@update');
    Route::delete('products/{id}','ProductController@destroy');

    Route::get('orders','OrderController@index');
    Route::post('orders/store','OrderController@store');
    Route::get('orders/{idOrder}','OrderController@show');
    Route::get('orders/{idOrder}/edit','OrderController@edit');
    Route::post('orders/update/{id}','OrderController@update');
    Route::delete('orders/{id}','OrderController@destroy');
});
