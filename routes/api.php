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
Route::domain(getenv('API_URL'))->group(function () {
    Passport::routes();

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['as' => 'v1.', 'namespace' => 'Api\v1', 'prefix' => 'v1'],
        function () {
            Route::middleware('auth:api')->group(function () {
                Route::resource('group', 'Channels\GroupsController');
            });
            Route::post('/registration', 'Auth\RegistrationController@registration')
                ->name('registration');
        });
});



