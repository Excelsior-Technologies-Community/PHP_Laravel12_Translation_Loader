<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageLineController;

Route::get('/', function () {
    return view('translation');
});

// language switch
Route::get('/set-language/{locale}', function ($locale) {
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect('/');
});

// CRUD routes
Route::resource('translations', LanguageLineController::class);
