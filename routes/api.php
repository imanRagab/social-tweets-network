<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => ['api'],
    'prefix' => 'v1/{locale}/auth',
    'where' => ['locale' => 'en|ar']
], function ($router) {
    Route::post('register', 'API\RegisterController@register');
    Route::post('login', 'API\AuthController@login',  ['name' => 'login']);
});

Route::group([
    'middleware' => ['api', 'jwt.verify'],
    'prefix' => 'v1/{locale}/me',
    'where' => ['locale' => 'en|ar']
], function ($router) {
    Route::post('tweets', 'API\TweetController@store');
});