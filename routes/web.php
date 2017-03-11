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

    Route::group(['prefix' => 'member', 'middleware' => 'can:manage-member'], function() {
        Route::get('/', 'MemberController@getIndex')
            ->name('app.member.index');
        Route::get('datatable', 'MemberController@getDatatable')
            ->name('app.member.datatable');
        Route::get('edit/{member}', 'MemberController@getEdit')
            ->name('app.member.edit');
        Route::post('update/{member}', 'MemberController@postUpdate')
            ->name('app.member.update');
    });

    Route::group(['prefix' => 'user', 'middleware' => 'can:manage-user'], function() {
        Route::get('/', 'UserController@getIndex')
            ->name('app.user.index');
        Route::get('datatable', 'UserController@getDatatable')
            ->name('app.user.datatable');
        Route::get('edit/{user}', 'UserController@getEdit')
            ->name('app.user.edit');
        Route::post('update/{user}', 'UserController@postUpdate')
            ->name('app.user.update');
    });
});