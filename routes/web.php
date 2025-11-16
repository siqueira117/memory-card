<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\GameManualController;
use App\Http\Controllers\GameNoteController;
use App\Http\Controllers\GameTagController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GameController::class, 'index'])->name('index');
Route::get('/sobre', [IndexController::class, 'aboutUs'])->name('about.us');

// Games
Route::prefix('game')->group(function () {
    Route::post('/addGame', [GameController::class, 'store'])->name('game.store');
    Route::post('/addManual', [GameManualController::class, 'store'])->name('manual.store');
    Route::get('/{slug}', [GameController::class, 'details'])->name('game.details');
    Route::post('/update-status', [GameController::class, 'updateStatus'])->name('game.update-status');
});

// API Routes for AJAX
Route::prefix('api')->group(function () {
    Route::get('/games/search', [GameController::class, 'searchGames'])->name('api.games.search');
    
    // Reviews API
    Route::get('/games/{gameId}/reviews', [ReviewController::class, 'index'])->name('api.reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('api.reviews.store');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('api.reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('api.reviews.destroy');
    Route::get('/games/{gameId}/user-review', [ReviewController::class, 'getUserReview'])->name('api.reviews.user');
    Route::get('/games/{gameId}/stats', [ReviewController::class, 'getGameStats'])->name('api.reviews.stats');
});

Route::get('/sugestoes', [SuggestionController::class, 'index'])->name('suggestion.index');
Route::post('/addSuggestion', [SuggestionController::class, 'store'])->name('suggestion.store');

Route::get('/faqs', [FaqsController::class, 'index'])->name('faqs.index');

// Usuário
Route::get('/register', [UserController::class, 'registerView'])->name('user.registerView');
Route::post('/register', [UserController::class, 'register'])->name('user.register');
Route::post('/favorite/{gameId}', [FavoriteController::class, 'toggleFavorite'])->middleware('auth');

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
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');

    // Coleções
    Route::prefix('collections')->group(function () {
        Route::get('/', [CollectionController::class, 'index'])->name('collections.index');
        Route::get('/explore', [CollectionController::class, 'explore'])->name('collections.explore');
        Route::get('/create', [CollectionController::class, 'create'])->name('collections.create');
        Route::post('/', [CollectionController::class, 'store'])->name('collections.store');
        Route::get('/{slug}', [CollectionController::class, 'show'])->name('collections.show');
        Route::get('/{slug}/edit', [CollectionController::class, 'edit'])->name('collections.edit');
        Route::put('/{slug}', [CollectionController::class, 'update'])->name('collections.update');
        Route::delete('/{slug}', [CollectionController::class, 'destroy'])->name('collections.destroy');
        Route::post('/add-game', [CollectionController::class, 'addGame'])->name('collections.add-game');
        Route::post('/remove-game', [CollectionController::class, 'removeGame'])->name('collections.remove-game');
        Route::post('/{slug}/follow', [CollectionController::class, 'toggleFollow'])->name('collections.follow');
        Route::get('/{slug}/export-json', [CollectionController::class, 'exportJson'])->name('collections.export.json');
        Route::get('/{slug}/export-csv', [CollectionController::class, 'exportCsv'])->name('collections.export.csv');
        Route::post('/{slug}/auto-cover', [CollectionController::class, 'autoGenerateCover'])->name('collections.auto-cover');
        Route::delete('/{slug}/cover', [CollectionController::class, 'removeCover'])->name('collections.remove-cover');
    });

    // Tags de Jogos
    Route::prefix('tags')->group(function () {
        Route::post('/', [GameTagController::class, 'store'])->name('tags.store');
        Route::delete('/{id}', [GameTagController::class, 'destroy'])->name('tags.destroy');
        Route::get('/game/{gameId}', [GameTagController::class, 'getGameTags'])->name('tags.game');
        Route::get('/user', [GameTagController::class, 'getUserTags'])->name('tags.user');
    });

    // Notas de Jogos
    Route::prefix('notes')->group(function () {
        Route::post('/', [GameNoteController::class, 'store'])->name('notes.store');
        Route::get('/game/{gameId}', [GameNoteController::class, 'getGameNote'])->name('notes.game');
        Route::delete('/game/{gameId}', [GameNoteController::class, 'destroy'])->name('notes.destroy');
    });

    // API: Coleções do usuário (para modal)
    Route::get('/api/user/collections', [CollectionController::class, 'getUserCollections'])->name('api.user.collections');
});

