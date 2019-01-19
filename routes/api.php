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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/currencies', 'CurrencyController@index');

Route::apiResources([
    'categories' => 'API\CategoriesController',
    'topics' => 'API\TopicsController',
]);
Route::post('user/register', 'API\UserController@register');

Route::group(['middleware' => ['api','cors']], function () {
    Route::post('user/register', 'API\UserController@register');     // 注册
    Route::post('user/login', 'API\UserController@login');           // 登陆
    Route::group(['middleware' => 'custom.jwt'], function () {
        Route::get('user/refresh', 'API\UserController@refresh');
        Route::get('user/logout', 'API\UserController@logout');
        Route::get('user/me', 'API\UserController@me');
    });
});