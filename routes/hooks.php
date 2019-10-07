<?php

use Illuminate\Http\Request;

Route::namespace('Hooks')->group(function(){
    Route::post('/vk/{id}','VkController@acceptHook');
});

