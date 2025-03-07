<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MasterChiefController;
use App\Http\Controllers\SuggestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);
Route::get('/sobre', [IndexController::class, 'aboutUs'])->name('about.us');

Route::get('/masterchief', [MasterChiefController::class, 'index'])->name('masterchief');

Route::post('/addGame', [GameController::class, 'store'])->name('game.store');
//Route::get('/gameDetails/{slug}', [Game::class, 'details'])->name('game.details');


Route::get('/sugestoes', [SuggestionController::class, 'index'])->name('suggestion.index');
Route::post('/addSuggestion', [SuggestionController::class, 'store'])->name('suggestion.store');