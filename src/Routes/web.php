<?php

if (config('laralang.default.routes')) {
    Route::group(['middleware' => 'web', 'as' => 'laralang::', 'prefix' => config('laralang.default.prefix'), 'namespace' => 'Aitor24\Laralang\Controllers'], function () {
        Route::get('/login', 'LaralangController@showLogin')->name('login');
        Route::post('/login', 'LaralangController@login');
        if (config('laralang.default.api')) {
            Route::group(['middleware' => ['throttle:5000,1', 'bindings']], function () {
                Route::post('/api/translate', 'LaralangController@apiTranslate')->name('apiTranslate');
            });
        }
        Route::group(['middleware' => 'laralang.middleware'], function () {
            Route::get('/', function () {
                return redirect(Route('laralang::translations'));
            })->name('home');
            Route::get('/translations', 'LaralangController@showTranslations')->name('translations');

            Route::get('/translations/filter', 'LaralangController@showTranslationsFilter')->name('filter');
            Route::post('/translations/filter', 'LaralangController@translationsFilter')->name('filter_post');
            Route::get('/translations/filter/from/{from_lang}/to/{to_lang}', 'LaralangController@showTranslationsFiltered')->name('filterFromTo');

            Route::post('/delete', 'LaralangController@deleteTranslation')->name('deleteTrans');
            Route::post('/delete/all', 'LaralangController@deleteAllTranslations')->name('deleteAll');

            Route::post('/edit', 'LaralangController@editTranslation')->name('editTrans');
            Route::get('/logout', 'LaralangController@logout')->name('logout');

            Route::group(['middleware' => ['throttle:5000,1', 'bindings']], function () {
                Route::get('/api', 'LaralangController@api')->name('api');
                Route::get('/api/filter/from/{from_lang}/to/{to_lang}', 'LaralangController@apiFilterFromTo')->name('apiFilterFromTo');
            });
        });
    });
}
