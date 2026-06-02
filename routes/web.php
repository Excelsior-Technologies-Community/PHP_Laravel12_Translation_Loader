<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageLineController;

Route::get('/', function () {
    return view('translation');
});

Route::get('/set-language/{locale}', function ($locale) {
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect('/');
});

Route::prefix('translations')->name('translations.')->group(function () {
    Route::get('/', [LanguageLineController::class, 'index'])->name('index');
    Route::get('/create', [LanguageLineController::class, 'create'])->name('create');
    Route::post('/', [LanguageLineController::class, 'store'])->name('store');
    Route::post('/inline/{id}', [LanguageLineController::class, 'updateInline'])->name('updateInline');
    Route::get('/history/{id}', [LanguageLineController::class, 'history'])->name('history');
    Route::post('/rollback/{id}', [LanguageLineController::class, 'rollback'])->name('rollback');
    Route::delete('/{id}', [LanguageLineController::class, 'destroy'])->name('destroy');
});