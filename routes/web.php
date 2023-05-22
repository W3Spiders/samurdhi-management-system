<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GnDivisionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WardController;

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

Route::get('/', function () {
    return redirect('/dashboard');
});


// Admin
Route::get('/login', [PageController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // General Pages
    Route::get('/dashboard', [PageController::class, 'showDashboard'])->name('dashboard');
    Route::get('/family-units', [PageController::class, 'showFamilyUnits'])->name('familyUnits');
    Route::get('/family-units/{id}', [PageController::class, 'showFamilyUnit'])->name('familyUnit');

    // Settings Pages
    Route::get('/settings/wards', [PageController::class, 'showWardManage'])->name(('settings.wards'));
    Route::get('/settings/gn-divisions', [PageController::class, 'showGnDivisionManage'])->name(('settings.gnDivisions'));

    Route::post('/ward', [WardController::class, 'store'])->name(('ward'));
    Route::post('/gn-division', [GnDivisionController::class, 'store'])->name(('gnDivision'));

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});