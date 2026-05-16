<?php
// File: routes/web.php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Auth\WalletController;

Route::post('/connect-wallet', [WalletController::class, 'connect'])->name('wallet.connect');

Route::middleware('auth')->group(function () {
    Volt::route('/check-in', 'game.check-in')->name('check-in');
    Volt::route('/leaderboard', 'leaderboard')->name('leaderboard');
    Volt::route('/inventory', 'inventory')->name('inventory');
    Volt::route('/referrals', 'referrals')->name('referrals');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');