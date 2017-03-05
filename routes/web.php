<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Auth'], function() {
    Route::get('login', 'LoginController@getLogin')
        ->name('auth.login');
    Route::get('logout', 'LoginController@getLogout')
        ->name('auth.logout');
});

Route::group(['namespace' => 'App'], function() {
    Route::get('dashboard', 'DashboardController@getIndex')
        ->name('app.dashboard.index');

    Route::group(['prefix' => 'member'], function() {
        Route::get('/', 'MemberController@getIndex')
            ->name('app.member.index');
        Route::get('datatable', 'MemberController@getDatatable')
            ->name('app.member.datatable');
    });
});