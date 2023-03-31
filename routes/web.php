<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers\\Admin')->prefix('admin')->as('admin.')->group(function () {
    Route::namespace('Auth')->as('auth.')->group(function () {
        // Authentication Routes...
        Route::get('login', 'LoginController@index')->name('login');
        Route::post('login', 'LoginController@authenticate')->name('authenticate');

        // Forgot Password Routes...
        Route::get('forgot-password', 'ForgotPasswordController@index')->name('password.request');
        Route::post('forgot-password', 'ForgotPasswordController@store')->name('password.email');

        // Reset Password Routes...
        Route::get('reset-password/{token}', 'ResetPasswordController@index')->name('password.reset');
        Route::post('reset-password', 'ResetPasswordController@store')->name('password.update');
    });

    Route::middleware('admin')->group(function () {
        // Destroy Session Route
        Route::namespace('Auth')->as('auth.')->group(function () {
            Route::get('logout', 'LogoutController@destroy')->name('logout');
        });
    });
});

Route::namespace('App\\Http\\Controllers\\Admin')->prefix('admin')->middleware('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/cache', 'DashboardController@cache')->name('cache');
    Route::get('/maintenance', 'DashboardController@maintenance')->name('maintenance');

    Route::get('settings/create', 'SettingController@create')->name('settings.create');
    Route::get('settings', 'SettingController@index')->name('settings.index');
    Route::post('settings', 'SettingController@store')->name('settings.store');

    Route::get('languages', 'LanguageController@index')->name('languages.index');
    Route::get('languages/create', 'LanguageController@create')->name('languages.create');
    Route::get('languages/edit/{id}', 'LanguageController@edit')->name('languages.edit');
    Route::delete('languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');
    Route::post('languages/store', 'LanguageController@store')->name('languages.store');
    Route::put('languages/update/{id}', 'LanguageController@update')->name('languages.update');

    Route::get('translations', 'TranslationController@index')->name('translations.index');
    Route::get('translations/edit/{id}', 'TranslationController@edit')->name('translations.edit');
    Route::put('translations/update/{id}', 'TranslationController@update')->name('translations.update');

    Route::get('admins', 'AdminController@index')->name('admins.index');
    Route::get('admins/create', 'AdminController@create')->name('admins.create');
    Route::get('admins/edit/{id}', 'AdminController@edit')->name('admins.edit');
    Route::delete('admins/destroy/{id}', 'AdminController@destroy')->name('admins.destroy');
    Route::post('admins/store', 'AdminController@store')->name('admins.store');
    Route::put('admins/update/{id}', 'AdminController@update')->name('admins.update');

    Route::get('cache', 'DashboardController@cache')->name('cache');
    Route::get('maintenance', 'DashboardController@maintenance')->name('maintenance');
});
