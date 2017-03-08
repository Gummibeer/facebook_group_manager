<?php

Route::get('/', function() {
    return redirect()->route('auth.login');
});

Route::group(['namespace' => 'Auth'], function() {
    Route::get('login', 'LoginController@getLogin')
        ->name('auth.login');
    Route::get('facebook/redirect', 'LoginController@getFacebookRedirect')
        ->name('auth.facebook.redirect');
    Route::get('facebook/callback', 'LoginController@getFacebookCallback')
        ->name('auth.facebook.callback');
    Route::get('logout', 'LoginController@getLogout')
        ->name('auth.logout');
});

Route::group(['namespace' => 'App', 'middleware' => 'auth'], function() {
    Route::get('dashboard', 'DashboardController@getIndex')
        ->name('app.dashboard.index');

    Route::group(['prefix' => 'member'], function() {
        Route::get('/', 'MemberController@getIndex')
            ->name('app.member.index');
        Route::get('datatable', 'MemberController@getDatatable')
            ->name('app.member.datatable');
    });
});