<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function (){
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/testimg', 'Admin\Channels\ChannelController@testimg')->name('testimg');

    Route::resource('group', 'Admin\Channels\GroupsController');

    Route::resource('channel', 'Admin\Channels\ChannelController');
});

Auth::routes();


