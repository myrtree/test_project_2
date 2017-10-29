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

Route::prefix('v1')->group(function () {
    Route::post('/auth', 'Api\v1\AuthController');

    Route::middleware('jwt.auth')->group(function () {
        Route::resource('/users', 'Api\v1\UserController');

        Route::resource('/clients', 'Api\v1\ClientController');
        Route::get('/clients/{clientId}/labels', 'Api\v1\LabelController@index');
        Route::post('/clients/{clientId}/labels', 'Api\v1\ClientController@attachLabels');
        Route::get('/clients/{clientId}/meetings', 'Api\v1\MeetingController@index');
        Route::post('/clients/{clientId}/meetings', 'Api\v1\ClientController@attachMeetings');
        Route::get('/clients/{clientId}/future-meetings', 'Api\v1\ClientController@futureMeetings');

        Route::get('/meetings/future-meetings', 'Api\v1\MeetingController@futureMeetings');
        Route::resource('/meetings', 'Api\v1\MeetingController');

        Route::resource('/labels', 'Api\v1\LabelController');
    });
});
