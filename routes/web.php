<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

route::get('/dashboard/mitra', [ MitraController::class, 'index'])->name('mitra.index')->middleware(['auth', 'role:mitra']);;

Route::middleware(['auth', 'role:warga'])->group(function () {

    Route::get('/dashboard/warga', [WargaController::class, 'index'])
        ->name('warga.index');

    Route::get('/warga/deposits/create', [DepositController::class, 'create'])
        ->name('deposits.create');

    Route::post('/warga/deposits/store', [DepositController::class, 'store'])
        ->name('deposits.store');
});

route::get('/dashboard/admin', [ AdminController::class, 'index'])->name('admin.index')->middleware(['auth', 'role:admin']);;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';

