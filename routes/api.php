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
    Route::get('customers','CustomerController@index');
    Route::post('customers/store','CustomerController@store');
    Route::get('customers/{idCustomer}','CustomerController@show');
    Route::get('customers/{idCustomer}/edit','CustomerController@edit');
    Route::post('customers/update/{idCustomer}','CustomerController@update');
    Route::delete('customers/{id}','CustomerController@destroy');

});
