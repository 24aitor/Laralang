<?php

Route::group(['middleware' => 'web', 'as' => 'laralang::', 'prefix' => config('laralang.default.prefix'), 'namespace' => 'Aitor24\Laralang\Controllers'], function () {
    Route::get('/login', 'LaralangController@showLogin')->name('login');
    Route::post('/login', 'LaralangController@login');

    Route::group(['middleware' => 'laralang.middleware'], function () {
        Route::get('/', 'LaralangController@showTranslations')->name('translations');
        Route::get('/delete/{id}', 'LaralangController@deleteTrans')->name('delete');
        Route::get('/edit/{id}/{translation}', 'LaralangController@editTrans');
        Route::get('/logout', 'LaralangController@logout')->name('logout');
        Route::group(['middleware' => 'api'], function () {
            Route::get('/api', 'LaralangController@api')->name('api');
        });
    });
    Route::get('/{slug}', 'LaralangController@redirect')->name('redirect');
});
