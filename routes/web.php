<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/categories', function () {
    $categories = [
        ['id'=>1, 'name'=>'Gaji', 'type'=>'income', 'icon'=>'💰'],
        ['id'=>2, 'name'=>'Investasi', 'type'=>'income', 'icon'=>'📈'],
        ['id'=>3, 'name'=>'Makanan', 'type'=>'expense', 'icon'=>'🍔'],
        ['id'=>4, 'name'=>'Transport', 'type'=>'expense', 'icon'=>'🚌'],
    ];

    return view('pages.categories')->with('categories', $categories);
})->middleware(['auth', 'verified'])->name('categories');


Route::get('/transactions', function () {
    return view('pages.transactions');
})->middleware(['auth', 'verified'])->name('transactions');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
