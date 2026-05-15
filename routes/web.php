<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AIScanController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\WasteTypesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard/mitra', [ MitraController::class, 'index'])->name('mitra.index')->middleware(['auth', 'role:mitra']);;

Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/warga/dashboard', [WargaController::class, 'index'])
        ->name('warga.dashboard');
    //  Route::get('/warga/deposits/scan', [DepositController::class, 'scanAI'])
    //     ->name('warga.scan');

    // Route::get('/warga/pilih-bank', [MapController::class, 'index'])
    //     ->name('warga.map');

    // Route::get('/warga/deposits', [DepositController::class, 'index'])
    //     ->name('warga.deposits.index');
    // Route::get('/warga/deposits/create', [DepositController::class, 'create'])
    //     ->name('warga.deposits.create');
    // Route::post('/warga/deposits', [DepositController::class, 'store'])
    //     ->name('warga.deposits.store');
    // Route::get('/warga/deposits/{id}/edit', [DepositController::class, 'edit'])
    //     ->name('warga.deposits.edit');
    // Route::put('/warga/deposits/{id}', [DepositController::class, 'update'])
    //     ->name('warga.deposits.update');
    // Route::delete('/warga/deposits/{id}', [DepositController::class, 'destroy'])
    //     ->name('warga.deposits.destroy');
    // Route::get('/warga/deposits/{id}', [DepositController::class, 'show'])
    // ->name('warga.deposits.show');

    Route::resource('deposits', DepositController::class);

    Route::get('/pilih-bank', [MapController::class, 'index'])->name('warga.pilih-bank');
    Route::post('/pilih-bank', [MapController::class, 'selectBank'])->name('warga.map.select');

    Route::get('/ai-scan', [AIScanController::class, 'index'])->name('warga.ai-scan');
    Route::post('/ai-scan/map', [AIScanController::class, 'mapClass'])->name('warga.ai.map');

});
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/dashboard/admin', [ AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/mitra', [AdminController::class, 'mitra'])->name('admin.mitra');
    Route::post('/admin/mitra/{id}/approve', [AdminController::class, 'approve'])->name('admin.mitra.approve');
    Route::get('/admin/setoran', [AdminController::class, 'setoran'])->name('admin.setoran');

    Route::get('/banks/{bank}/edit', [AdminController::class, 'banksEdit'])->name('admin.banks.edit');
    Route::put('/banks/{bank}', [AdminController::class, 'banksUpdate'])->name('admin.banks.update');
    Route::get('/banks/{bank}/location', [AdminController::class, 'banksLocation'])->name('admin.banks.location');
    Route::put('/banks/{bank}/location', [AdminController::class, 'banksUpdateLocation'])->name('admin.banks.location.update');
    Route::delete('/banks/{bank}', [AdminController::class, 'banksDestroy'])->name('admin.banks.destroy');
    
    Route::get('admin/waste-types', [WasteTypesController::class, 'index'])->name('admin.waste-types.index');
    Route::get('waste-types/create', [WasteTypesController::class, 'create'])->name('admin.waste-types.create');
    Route::post('waste-types', [WasteTypesController::class, 'store'])->name('admin.waste-types.store');
    Route::get('waste-types/{wasteType}/edit', [WasteTypesController::class, 'edit'])->name('admin.waste-types.edit');
    Route::put('waste-types/{wasteType}', [WasteTypesController::class, 'update'])->name('admin.waste-types.update');
    Route::delete('waste-types/{wasteType}', [WasteTypesController::class, 'destroy'])->name('admin.waste-types.destroy');
    Route::post('waste-types/{wasteType}/toggle-status', [WasteTypesController::class, 'toggleStatus'])->name('admin.waste-types.toggle-status');

    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'pdf'])->name('admin.reports.pdf');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';

Route::post('/deposit/{id}/decision', [MitraController::class, 'decision']);