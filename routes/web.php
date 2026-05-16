<?php
// File: routes/web.php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Volt::route('/check-in', 'game.check-in')->name('check-in');
Volt::route('/leaderboard', 'leaderboard')->name('leaderboard');
Volt::route('/inventory', 'inventory')->name('inventory');