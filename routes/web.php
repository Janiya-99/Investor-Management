<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;

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


Auth::routes();


// Define a group of routes with 'auth' middleware applied
Route::middleware(['auth'])->group(function () {
    // Define a GET route for the root URL ('/')
    Route::get('/', function () {
        // Return a view named 'index' when accessing the root URL
        return view('index');
    });

    Route::resource('users',UserController::class)->names('users');

    Route::get('investors/branches/{bankId}', [InvestorController::class, 'getBranchesByBank'])->name('investors.branches');
    Route::get('investors/documents', [InvestorController::class, 'documentsPage'])->name('investors.documents.edit');
    Route::put('investors/documents', [InvestorController::class, 'updateDocuments'])->name('investors.documents.update');
    Route::get('investors/bank-details', [InvestorController::class, 'bankDetailsPage'])->name('investors.banks.edit');
    Route::put('investors/bank-details', [InvestorController::class, 'updateBankDetails'])->name('investors.banks.update');
    Route::resource('investors',InvestorController::class)->names('investors');

    Route::resource('products',ProductController::class)->names('products');

    Route::resource('roles',\App\Http\Controllers\RoleController::class)->names('roles');

    Route::resource('permissions',\App\Http\Controllers\PermissionController::class)->names('permissions');

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('activity-logs/{id}', [ActivityLogController::class, 'show'])->name('activity-logs.show');

    // Define a GET route with dynamic placeholders for route parameters
    Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});
