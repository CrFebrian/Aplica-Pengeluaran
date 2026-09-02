<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Categories\CategoryManager;
use App\Livewire\Debts\DebtList;
use App\Livewire\Transactions\TransactionList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

// route halaman daftar transaksi
Route::get('transactions', TransactionList::class)
    ->middleware(['auth'])
    ->name('transactions.index');

//  route halaman hutang
Route::get('debts', DebtList::class)
    ->middleware(['auth'])
    ->name('debts.index');

// route halaman pengaturan kategori
Route::get('categories', CategoryManager::class)
    ->middleware(['auth'])
    ->name('categories.index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('logout', function (Logout $logout) {
    $logout();

    return redirect('/');
})->middleware(['auth'])->name('logout');

require __DIR__.'/auth.php';
