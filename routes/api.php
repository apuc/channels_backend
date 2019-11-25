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

        Route::middleware('auth:api')->group(function () {

            Route::get('/channel/{id}', 'Channels\ChannelsController@show')->name('channel.show');

            Route::group([], function () {
                Route::resource('group', 'Channels\GroupsController')->except(['edit', 'create']);
                Route::post('group/{group_id}/channels', 'Channels\GroupsController@channels')->name('group.channels');
                Route::delete('group/{group_id}/delete-channel', 'Channels\GroupsController@deleteChannel')->name('group.delete-channel');
            });

            Route::delete('/channel/delete-user', 'Channels\ChannelsController@deleteUser')->name('channel.deleteUser');
            Route::resource('channel', 'Channels\ChannelsController')->except(['edit', 'create', 'show']);

            Route::resource('attachment', 'Channels\AttachmentsController');
            Route::post('/attachment/upload','Channels\AttachmentsController@upload');

            Route::post('/user/avatar', 'Users\UsersController@avatar')->name('user.avatar');
            Route::put('/user/profile/{id}', 'Users\UsersController@profile')->name('user.profile');
            Route::get('/user/me', 'Users\UsersController@me')->name('get current user');
            Route::post('/user/add-contact', 'Users\UsersController@addContact')->name('user.add-contact');
            Route::put('/user/confirm-contact', 'Users\UsersController@confirmContact')->name('user.confirm-contact');
            Route::delete('/user/reject-contact', 'Users\UsersController@rejectContact')->name('user.reject-contact');
            Route::get('/user/contacts', 'Users\UsersController@contacts')->name('user.contacts');
            Route::get('/user/senders', 'Users\UsersController@senders')->name('user.senders');
            Route::resource('user', 'Users\UsersController')->except(['edit', 'create']);

            Route::post('/channel/avatar', 'Channels\ChannelsController@avatar')->name('channel.avatar');
            Route::post('/channel/add-user', 'Channels\ChannelsController@addUser')->name('channel.addUser');
            Route::get('/channel/delava/{avatar}', 'Channels\ChannelsController@delava')->name('delava');
            Route::get('/channel/{channel}/users', 'Channels\ChannelsController@usersList')->name('users.list');
            Route::get('/channel/{channel}/messages', 'Channels\ChannelsController@messagesList')->name('messages.list');
            Route::get('/channel/service/left-side-bar', 'Channels\ServiceController@leftSideBar')->name('channels.service.leftSideBar');
            Route::post('/group/avatar', 'Channels\GroupsController@avatar')->name('group.avatar');
            Route::get('/group/delava/{avatar}', 'Channels\GroupsController@delava')->name('delava');

            Route::resource('integrations', 'Integrations\IntegrationsController')->only(['index', 'store']);
            Route::post('/channels/{channel}/integrations', 'Channels\ChannelsController@addIntegration')->name('channels.addIntegration');

            Route::post('/channels/{channel}/invite', 'Channels\ChannelsController@inviteByEmail')->name('channels.invite');
            Route::post('/dialog', 'Channels\ChannelsController@createDialog')->name('dialog.create');
            Route::get('/channels/popular', 'Channels\ChannelsController@popular')->name('channels.popular');


            Route::get('/single-link', 'Channels\LinkController@singleLink')->name('single-link');
            Route::get('/text-link', 'Channels\LinkController@textLink')->name('text-link');

            Route::post('/messages/read', 'Channels\MessagesController@markReadDialog')->name('messages.read');

        });


        /** Роуты для общения между сервисами*/
        Route::group(['as' => 'service', 'middleware' => 'auth:service', 'prefix' => 'service'], function () {
            Route::resource('message', 'Channels\MessagesController')->except(['edit', 'create', 'index']);

            Route::get('/user/me', 'Users\UsersController@me')->name('get current user');
        });

        Route::post('/registration', 'Auth\RegistrationController@registration')
            ->name('registration');
    });


