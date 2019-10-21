<?php

use Illuminate\Http\Request;

app('debugbar')->disable();

Route::namespace('Hooks')->group(function(){
    Route::post('/{type}/{id}','HooksController@handle');
});

