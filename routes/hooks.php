<?php

use Illuminate\Http\Request;

app('debugbar')->disable();

Route::namespace('Hooks')->group(function(){
    Route::post('/vk/{id}','VkController@acceptHook');
});

