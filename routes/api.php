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

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('user/invites/sent', 'UserController@sentInvites');
    Route::get('user/invites/received', 'UserController@receivedInvites');
    Route::post('user/invite/send', 'InviteController@send');
    Route::patch('user/invite/{invite}/cancel', 'InviteController@cancel');
    Route::patch('user/invite/{invite}/confirm', 'InviteController@confirm');
});