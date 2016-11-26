<?php
if (config('laralang.default.routes')) {
    Route::group(['middleware' => 'web', 'as' => 'laralang::', 'prefix' => config('laralang.default.prefix'), 'namespace' => 'Aitor24\Laralang\Controllers'], function () {
        Route::get('/login', 'LaralangController@showLogin')->name('login');
        Route::post('/login', 'LaralangController@login');

        Route::group(['middleware' => 'laralang.middleware'], function () {
            Route::get('/', function () {
                return redirect(Route('laralang::translations'));
            })->name('home');
            Route::get('/translations', 'LaralangController@showTranslations')->name('translations');
            Route::post('/delete', 'LaralangController@deleteTranslation')->name('delete');
            Route::post('/edit', 'LaralangController@editTranslation');
            Route::get('/logout', 'LaralangController@logout')->name('logout');
            Route::group(['middleware' => ['throttle:5000,1', 'bindings']], function () {
                Route::get('/api', 'LaralangController@api')->name('api');
            });
        });
    });
}
