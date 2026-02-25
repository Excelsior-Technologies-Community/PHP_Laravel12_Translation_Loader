<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('translation');
});

Route::get('/set-language/{locale}', function ($locale) {

    $allowedLocales = ['en', 'fr', 'hi'];

    if (in_array($locale, $allowedLocales)) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }

    return redirect('/');
});

