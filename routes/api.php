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

Route::middleware('auth:service')->group(function () {
    Route::get('v1/users/me', 'Api\v1\Users\UsersController@me')->name('get current user');
});
Route::group(['as' => 'v1.', 'namespace' => 'Api\v1', 'prefix' => 'v1'],
    function () {
        Passport::routes();

//        Route::middleware('auth:api')->get('/user', function (Request $request) {
//            return $request->user();
//        });

        Route::middleware('auth:api')->group(function () {

            Route::group([], function () {
                Route::resource('group', 'Channels\GroupsController')->except(['edit', 'create']);
                Route::post('group/{group_id}/channels', 'Channels\GroupsController@channels')->name('group.channels');
                Route::delete('group/{group_id}/delete-channel', 'Channels\GroupsController@deleteChannel')->name('group.delete-channel');
            });
            Route::delete('/channel/delete-user', 'Channels\ChannelsController@deleteUser')->name('channel.deleteUser');
            Route::resource('channel', 'Channels\ChannelsController')->except(['edit', 'create']);

            Route::post('/user/avatar', 'Users\UsersController@avatar')->name('user.avatar');
            Route::put('/user/profile/{id}', 'Users\UsersController@profile')->name('user.profile');
            Route::get('/user/me', 'Users\UsersController@me')->name('get current user');
            Route::resource('user', 'Users\UsersController')->except(['edit', 'create', 'index']);
            Route::post('/channel/avatar', 'Channels\ChannelsController@avatar')->name('channel.avatar');
            Route::post('/channel/add-user', 'Channels\ChannelsController@addUser')->name('channel.addUser');
            Route::get('/channel/delava/{avatar}', 'Channels\ChannelsController@delava')->name('delava');
            Route::get('/channel/{channel}/users', 'Channels\ChannelsController@usersList')->name('users.list');
            Route::get('/channel/{channel}/messages', 'Channels\ChannelsController@messagesList')->name('messages.list');
            Route::post('/group/avatar', 'Channels\GroupsController@avatar')->name('group.avatar');
            Route::get('/group/delava/{avatar}', 'Channels\GroupsController@delava')->name('delava');
        });

        /** Роуты для общения между сервисами*/
        Route::group(['as' => 'service', 'middleware' => 'auth:service', 'prefix' => 'service'], function () {
            Route::resource('message', 'Channels\MessagesController')->except(['edit', 'create', 'index']);

            Route::get('/user/me', 'Users\UsersController@me')->name('get current user');
        });

        Route::post('/registration', 'Auth\RegistrationController@registration')
            ->name('registration');
    });


