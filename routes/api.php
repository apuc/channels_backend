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

//        Route::middleware('auth:api')->get('/user', function (Request $request) {
//            return $request->user();
//        });

        Route::middleware('auth:api')->group(function () {
            Route::resource('group', 'Channels\GroupsController')->except(['edit', 'create']);
            Route::resource('channel', 'Channels\ChannelsController')->except(['edit', 'create']);
            Route::get('/user/me', 'Users\UsersController@user')->name('get current user');
            Route::resource('user', 'Users\UsersController')->except(['edit', 'create', 'index']);
            Route::post('/channel/avatar', 'Channels\ChannelsController@avatar')->name('channel avatar');
            Route::get('/channel/delava/{avatar}', 'Channels\ChannelsController@delava')->name('delava');
            Route::post('/group/avatar', 'Channels\GroupsController@avatar')->name('group avatar');
            Route::get('/group/delava/{avatar}', 'Channels\GroupsController@delava')->name('delava');
        });

        Route::post('/registration', 'Auth\RegistrationController@registration')
            ->name('registration');
    });


