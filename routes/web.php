<?php

use App\Models\ArticleCategory;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AbTestDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

Route::get('/', function () {
    return view('welcome');
});

// Test Data
Route::get('/testdata', [AbTestDataController::class, 'index']);

// Logout (Nur für authentifizierte Benutzer)
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Anmeldung (Nur für Gäste)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('show.login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');

// Registrierung (Nur für Gäste)
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('show.register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');

// Artikel (Nur für authentifizierte Benutzer)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles')->middleware('auth');
Route::get('/newarticle', [ArticleController::class, 'showArticleForm'])->name('show.articleForm')->middleware('auth');
Route::post('/articles', [ArticleController::class, 'store'])->middleware('auth');


// Article Category
Route::get('/api/kategorien', function () {    // /api/-Prefix bedeutet gibt Ergebnis als JSON-Daten zurück
    return ArticleCategory::all('ab_name');
});

// New site
Route::get('/newsite', function () {
    return view('newsite');
});
