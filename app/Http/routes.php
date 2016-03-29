<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',  'HomePageController@index');
Route::get('/register', 'UserRegisterController@index');
Route::get('/products', 'AllProductsController@show');
Route::get('/show_products', 'ShowProductsController@index');
Route::get('/recommend_products', 'RecommendProductsController@index');
Route::get('/product/{id}', 'ProductDetailController@show');

Route::post('/register/create', 'UserRegisterController@create');
Route::post('/login', 'UserLoginController@index');
Route::post('/evaluation/{product_id}/{user_id}', 'UserEvaluationController@index');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
