<?php

use App\Http\Controllers\Game;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MasterChief;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);
Route::get('/masterchief', [MasterChief::class, 'index'])->name('masterchief');
Route::post('/addGame', [Game::class, 'store'])->name('addGame');
Route::get('/gameDetails/{slug}', [Game::class, 'details'])->name('game.details');