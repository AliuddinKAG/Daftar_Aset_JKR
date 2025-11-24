<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\MainComponentController;
use App\Http\Controllers\SubComponentController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', [ComponentController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Component Routes (Borang 1)
|--------------------------------------------------------------------------
*/

Route::prefix('components')->name('components.')->group(function () {
    Route::get('/', [ComponentController::class, 'index'])->name('index');
    Route::get('/trashed', [ComponentController::class, 'trashed'])->name('trashed');
    Route::post('/{id}/restore', [ComponentController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [ComponentController::class, 'forceDestroy'])->name('force-destroy');
    Route::get('/create', [ComponentController::class, 'create'])->name('create');
    Route::post('/', [ComponentController::class, 'store'])->name('store');
    Route::get('/{component}', [ComponentController::class, 'show'])->name('show');
    Route::get('/{component}/edit', [ComponentController::class, 'edit'])->name('edit');
    Route::put('/{component}', [ComponentController::class, 'update'])->name('update');
    Route::delete('/{component}', [ComponentController::class, 'destroy'])->name('delete');
});

/*
|--------------------------------------------------------------------------
| Main Component Routes (Borang 2)
|--------------------------------------------------------------------------
*/

Route::prefix('main-components')->name('main-components.')->group(function () {
    
    // PENTING: Route tanpa parameter MESTI diletakkan SEBELUM route dengan parameter
    Route::get('/generate-kod-lokasi', [MainComponentController::class, 'generateKodLokasi'])
        ->name('generate-kod-lokasi');
    Route::get('/trashed', [MainComponentController::class, 'trashed'])->name('trashed');
    Route::post('/{id}/restore', [MainComponentController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [MainComponentController::class, 'forceDestroy'])->name('force-destroy');
    Route::get('/create', [MainComponentController::class, 'create'])->name('create');
    Route::post('/', [MainComponentController::class, 'store'])->name('store');
    Route::get('/{mainComponent}', [MainComponentController::class, 'show'])->name('show');
    Route::get('/{mainComponent}/edit', [MainComponentController::class, 'edit'])->name('edit');
    Route::put('/{mainComponent}', [MainComponentController::class, 'update'])->name('update');
    Route::delete('/{mainComponent}', [MainComponentController::class, 'destroy'])->name('delete');
});

/*
|--------------------------------------------------------------------------
| Sub Component Routes (Borang 3)
|--------------------------------------------------------------------------
*/

Route::prefix('sub-components')->name('sub-components.')->group(function () {
    Route::get('/trashed', [SubComponentController::class, 'trashed'])->name('trashed');
    Route::post('/{id}/restore', [SubComponentController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [SubComponentController::class, 'forceDestroy'])->name('force-destroy');
    Route::get('/create', [SubComponentController::class, 'create'])->name('create');
    Route::post('/', [SubComponentController::class, 'store'])->name('store');
    Route::get('/{subComponent}', [SubComponentController::class, 'show'])->name('show');
    Route::get('/{subComponent}/edit', [SubComponentController::class, 'edit'])->name('edit');
    Route::put('/{subComponent}', [SubComponentController::class, 'update'])->name('update');
    Route::delete('/{subComponent}', [SubComponentController::class, 'destroy'])->name('delete');
});

/*
|--------------------------------------------------------------------------
| Export Routes - PDF & Excel
|--------------------------------------------------------------------------
*/

Route::prefix('export')->name('export.')->group(function () {
    Route::get('/component/{component}/pdf', [ExportController::class, 'exportComponentPDF'])->name('component.pdf');
    Route::get('/component/{component}/excel', [ExportController::class, 'exportComponentExcel'])->name('component.excel');
    Route::get('/main-component/{mainComponent}/pdf', [ExportController::class, 'exportMainComponentPDF'])->name('main-component.pdf');
    Route::get('/main-component/{mainComponent}/excel', [ExportController::class, 'exportMainComponentExcel'])->name('main-component.excel');
    Route::get('/sub-component/{subComponent}/pdf', [ExportController::class, 'exportSubComponentPDF'])->name('sub-component.pdf');
    Route::get('/sub-component/{subComponent}/excel', [ExportController::class, 'exportSubComponentExcel'])->name('sub-component.excel');
    Route::get('/complete-report/{component}/pdf', [ExportController::class, 'exportCompleteReportPDF'])->name('complete-report.pdf');
    Route::get('/complete-report/{component}/excel', [ExportController::class, 'exportCompleteReportExcel'])->name('complete-report.excel');
    Route::get('/all-components/pdf', [ExportController::class, 'exportAllComponentsPDF'])->name('all-components.pdf');
    Route::get('/all-components/excel', [ExportController::class, 'exportAllComponentsExcel'])->name('all-components.excel');
});