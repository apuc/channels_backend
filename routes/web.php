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

    Route::get('/testimg', 'Admin\Channels\ChannelController@testimg')->name('testimg');

    Route::resource('group', 'Admin\Channels\GroupsController');

    Route::resource('channel', 'Admin\Channels\ChannelController');

    Route::resource('service', 'Admin\ServiceAuthController');

    Route::resource('integration-types', 'Admin\Channels\IntegrationTypesController');

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs');
});
// Route for changing language...
Route::get('setting/change-language/{language}', 'SettingsController@changeLanguage');

Route::post('/bot-test', 'Admin\DashboardController@bot');

Route::domain(env('DOCS_DOMAIN','docs.duct.su'))->group(function () {
    Route::get('/v1', function () {
        return view('vendor.swagger.index');
    });
});

Auth::routes();


