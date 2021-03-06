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

Route::group(['namespace' => 'App', 'middleware' => ['auth','can:member']], function() {
    Route::get('dashboard', 'DashboardController@getIndex')
        ->name('app.dashboard.index');
    Route::get('activity/{day}', 'DashboardController@getActivity')
        ->name('app.dashboard.activity');


    Route::group(['prefix' => 'profile', 'middleware' => 'can:member'], function() {
        Route::get('/', 'ProfileController@getEdit')
            ->name('app.profile.edit');
        Route::post('/', 'ProfileController@postUpdate')
            ->name('app.profile.update');
    });

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

    Route::group(['prefix' => 'post', 'middleware' => 'can:view-post'], function() {
        Route::get('/', 'PostController@getIndex')
            ->name('app.post.index');
    });

    Route::group(['prefix' => 'autopost', 'middleware' => 'can:view-autopost'], function() {
        Route::get('/', 'AutopostController@getIndex')
            ->name('app.autopost.index');
    });

    Route::group(['prefix' => 'api'], function() {
        Route::group(['prefix' => 'post', 'middleware' => 'can:view-post'], function() {
            Route::get('/', 'PostController@getApiIndex')
                ->name('api.post.index');
            Route::get('/comments/{post}', 'PostController@getApiComments')
                ->name('api.post.comments');
        });
    });
});