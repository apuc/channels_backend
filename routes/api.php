<?php

use Illuminate\Http\Request;
use Laravel\Passport\Passport;

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
Route::group(['as' => 'v1.', 'namespace' => 'Api\v1', 'prefix' => 'v1'],
    function () {
        Passport::routes();

        Route::middleware('auth:api')->get('/user', function (Request $request) {
            return $request->user();
        });

        Route::middleware('auth:api')->group(function () {
            Route::resource('group', 'Channels\GroupsController')->except(['edit', 'create']);
        });

        Route::middleware('auth:api')->group(function () {
            Route::resource('channel', 'Channels\ChannelsController')->except(['edit', 'create']);
        });

        Route::post('/registration', 'Auth\RegistrationController@registration')
            ->name('registration');
    });


