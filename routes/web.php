<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameManualController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'index'])->name('index');
Route::get('/sobre', [IndexController::class, 'aboutUs'])->name('about.us');

Route::post('/addGame', [GameController::class, 'store'])->name('game.store');
Route::post('/addManual', [GameManualController::class, 'store'])->name('manual.store');

Route::get('/game/{slug}', [GameController::class, 'details'])->name('game.details');
// Route::get('/updateGames', [GameController::class, 'update'])->name('game.updates');

Route::get('/sugestoes', [SuggestionController::class, 'index'])->name('suggestion.index');
Route::post('/addSuggestion', [SuggestionController::class, 'store'])->name('suggestion.store');

Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');

// Usuário
Route::get('/register', [UserController::class, 'registerView'])->name('user.registerView');
Route::post('/register', [UserController::class, 'register'])->name('user.register');

// Route::get('/login', [UserController::class, 'loginView'])->name('user.loginView');
Route::post('/login', [UserController::class, 'login'])->name('user.login');

Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

Route::get('/updates', [ActivityController::class, 'index'])->name('logs.index');

Route::get('/changelog', function () {
    return view('changelog');
})->name('changelog');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'getUnreadNotifications'])->name('notifications');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

