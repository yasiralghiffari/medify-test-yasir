<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterItemsController;
use App\Http\Controllers\CategoriesController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Master Items Routes
Route::get('/master-items', [MasterItemsController::class, 'index']);
Route::get('/master-items/search', [MasterItemsController::class, 'search']);
Route::get('/master-items/export-excel', [MasterItemsController::class, 'exportExcel'])->name('master-items.export-excel');
Route::get('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [MasterItemsController::class, 'formSubmit']);
Route::get('/master-items/view/{kode}', [MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [MasterItemsController::class, 'delete']);
Route::get('/master-items/update-random-data', [MasterItemsController::class, 'updateRandomData']);

// Categories Routes
Route::get('/categories', [CategoriesController::class, 'index']);
Route::get('/categories/search', [CategoriesController::class, 'search']);
Route::get('/categories/form/{method}/{id?}', [CategoriesController::class, 'formView']);
Route::post('/categories/form/{method}/{id?}', [CategoriesController::class, 'formSubmit']);
Route::get('/categories/view/{id}', [CategoriesController::class, 'singleView']);
Route::get('/categories/delete/{id}', [CategoriesController::class, 'delete']);
Route::get('/categories/pdf/{id}', [CategoriesController::class, 'downloadPdf'])->name('categories.pdf');
