<?php

use App\Http\Controllers\Api\v1\Auth\PasswordResetController;
use App\Http\Controllers\Api\v1\Channels\ChannelsController;
use App\Http\Controllers\Api\v1\MeetingController;
use App\Http\Controllers\Api\v1\Users\UsersController;
use Laravel\Passport\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(['as' => 'v1.', 'namespace' => 'Api\v1', 'prefix' => 'v1'],
    function () {
        Passport::routes();

        Route::middleware('auth:api')->group(function () {

            //////////////// ГРУППЫ //////////////////////////////////
            Route::group([],function () {
                Route::resource('group', 'Channels\GroupsController')->except(['edit', 'create']);
                Route::post('group/{group_id}/channels', 'Channels\GroupsController@channels')->name('group.channels');
                Route::delete('group/{group_id}/delete-channel', 'Channels\GroupsController@deleteChannel')->name('group.delete-channel');
                Route::post('/group/avatar', 'Channels\GroupsController@avatar')->name('group.avatar');
                Route::get('/group/delava/{avatar}', 'Channels\GroupsController@delava')->name('delava');
            });

            ////////////// АТАЧМЕНТЫ ///////////////////
            Route::resource('attachment', 'Channels\AttachmentsController');
            Route::post('/attachment/upload','Channels\AttachmentsController@upload');

            ////////////////// ПОЛЬЗОВАТЕЛИ ////////////////////////////////
            Route::get('/user/{id}/integrations', [UsersController::class,'integrations']);
            Route::post('/user/avatar', 'Users\UsersController@avatar')->name('user.avatar');
            Route::put('/user/profile/{id}', 'Users\UsersController@profile')->name('user.profile');
            Route::get('/user/me', 'Users\UsersController@me')->name('get current user');
            Route::post('/user/add-contact', 'Users\UsersController@addContact')->name('user.add-contact');
            Route::put('/user/confirm-contact', 'Users\UsersController@confirmContact')->name('user.confirm-contact');
            Route::delete('/user/reject-contact', 'Users\UsersController@rejectContact')->name('user.reject-contact');
            Route::get('/user/contacts', 'Users\UsersController@contacts')->name('user.contacts');
            Route::get('/user/senders', 'Users\UsersController@senders')->name('user.senders');
            Route::resource('user', 'Users\UsersController')->except(['edit', 'create']);

            ////////////////// ПУШ УВЕДОМЛЕНИЯ ////////////////////////////////
            Route::post('/user/{id}/push-subscribe', 'Channels\PushNotificationsController@subscribe')->name('push.subscribe');
            Route::post('/user/{id}/push-unsubscribe', 'Channels\PushNotificationsController@unSubscribe')->name('push.unsubscribe');

            ////////////// КАНАЛЫ //////////////////
            Route::delete('/channel/delete-user', 'Channels\ChannelsController@deleteUser')->name('channel.deleteUser');
            Route::post('/channel/avatar', 'Channels\ChannelsController@avatar')->name('channel.avatar');
            Route::post('/channel/add-user', 'Channels\ChannelsController@addUser')->name('channel.addUser');
            Route::get('/channel/delava/{avatar}', 'Channels\ChannelsController@delava')->name('delava');
            Route::get('/channel/{channel}/users', 'Channels\ChannelsController@usersList')->name('users.list');
            Route::get('/channel/service/left-side-bar', 'Channels\ServiceController@leftSideBar')->name('channels.service.leftSideBar');
            Route::get('/channel/{id}', 'Channels\ChannelsController@show')->name('channel.show');

            Route::post('/channels/{channel}/invite', 'Channels\ChannelsController@inviteByEmail')->name('channels.invite');
            Route::post('/dialog', 'Channels\ChannelsController@createDialog')->name('dialog.create');
            Route::get('/channels/popular', 'Channels\ChannelsController@popular')->name('channels.popular');

            Route::resource('channel', 'Channels\ChannelsController')->except(['edit', 'create', 'show']);

            ////////////// ИНТЕГРАЦИИ //////////////////
            Route::resource('integrations', 'Integrations\IntegrationsController')->only(['index', 'store']);
            Route::post('/channels/{channel}/integrations', 'Channels\ChannelsController@addIntegration')->name('channels.addIntegration');
            Route::get('/channels/{channel}/integrations', 'Channels\ChannelsController@integrationsList')->name('channels.integrationsList');
            Route::delete('/channels/{channel}/integrations/{integration}', 'Channels\ChannelsController@removeIntegration')->name('channels.removeIntegration');

            ////////// ССЫЛКИ ////////////////
            Route::post('/single-link', 'Channels\LinkController@singleLink')->name('single-link');
            Route::post('/text-link', 'Channels\LinkController@textLink')->name('text-link');

            ////////////// СООБЩЕНИЯ /////////////////
            Route::resource('message', 'Channels\MessagesController')->only(['update','destroy','show']);
            Route::post('/messages/read', 'Channels\MessagesController@markReadDialog')->name('messages.read');
            Route::post('/messages/read/chat', 'Channels\MessagesController@markReadChat')->name('messages.read.chat');

            ////////////// БОТЫ /////////////////
            Route::resource('bot', 'Users\BotController')->except(['create','edit']);
        });

        //Канал для не авторизованых
        Route::middleware('channel.auth')->group(function(){
            Route::get('/channel/{id}/messages', [ChannelsController::class,'messagesList']);
            Route::get('/channel/{id}/full', [ChannelsController::class,'showFull']);
        });

        Route::post('/bot/send-message', 'Users\BotController@sendMessage')
            ->middleware('bot.api')
            ->name('bot.message');

        Route::resource('meeting','MeetingController')->only('store');

        /** Роуты для общения между сервисамииии*/
        Route::group(['as' => 'service', 'middleware' => 'auth:service', 'prefix' => 'service'], function () {
            Route::resource('message', 'Channels\MessagesController')->only(['store']);
            Route::post('/channel/{id}/users-push', 'Channels\PushNotificationsController@getUsersToPush')->name('push.users');

            Route::resource('meeting','MeetingController')->only('show');

            Route::get('/user/me', 'Users\UsersController@me');
        });

        Route::post('/registration', 'Auth\RegistrationController@registration')
            ->name('registration');

        Route::post('/request-reset', [PasswordResetController::class,'requestReset'])
            ->name('request.reset');

        Route::post('/reset', [PasswordResetController::class,'reset'])
            ->name('reset');
    });


