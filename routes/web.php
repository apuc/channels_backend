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
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');

    Route::resource('group', 'Admin\Channels\GroupsController');

    Route::resource('channel', 'Admin\Channels\ChannelController');
});
// Route for changing language...
Route::get('setting/change-language/{language}', 'SettingsController@changeLanguage');

Auth::routes();


