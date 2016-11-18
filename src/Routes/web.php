<?php
Route::group(['middleware' => 'web', 'as' => 'laralang::', 'prefix' => config('laralang.default.prefix'), 'namespace' => 'Aitor24\Laralang\Controllers'], function() {

    Route::get('/translations', 'LaralangController@retView')->name('translations');
    Route::get('/test', 'LaralangController@testfunction');
    Route::post('/test', 'LaralangController@testfunction');
    Route::get('/delete/{id}', 'LaralangController@deleteTrans')->name('delete');
    Route::get('/edit/{id}/{translation}', 'LaralangController@editTrans');
});

Route::group(['middleware' => ['bindings', 'throttle:1000,1'], 'as' => 'laralang::', 'prefix' => config('laralang.default.prefix'), 'namespace' => 'Aitor24\Laralang\Controllers'], function() {
    Route::get('/api', 'LaralangController@api')->name('api');
});
