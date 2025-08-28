<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Crm\Http\Controllers\CompanyLocationController;

Route::prefix('crm')->group(function() {
    Route::get('/', 'CrmController@index');
});
Route::name('company_location.')->prefix('company_location')->group(function () {
    Route::get('/list', [CompanyLocationController::class, 'index'])->name('index');
    Route::get('/location-list/{company:id}', [CompanyLocationController::class, 'locationList'])->name('locationList');
    Route::get('/dataProcessing', [CompanyLocationController::class, 'dataProcessing'])->name('dataProcessing');
    Route::get('/location/dataProcessing/{company_id}', [CompanyLocationController::class, 'locationDataProcessing'])->name('location.dataProcessing');
    // Route::get('/create', [CompanyController::class, 'create'])->name('create');
    // Route::post('/store', [CompanyController::class, 'store'])->name('store');
    Route::get('/show/{company:id}', [CompanyLocationController::class, 'show'])->name('show');
    Route::get('/edit/{company:id}', [CompanyLocationController::class, 'edit'])->name('edit');
    Route::post('/update/{company:id}', [CompanyLocationController::class, 'update'])->name('update');
    Route::get('/delete/{company:id}', [CompanyLocationController::class, 'destroy'])->name('destroy');
});
