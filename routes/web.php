<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyUnitController;
use App\Http\Controllers\GnDivisionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SamurdhiPaymentRequestController;
use App\Http\Controllers\UserController;
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


// Guest Users
Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'show_login'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});


// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Family Units
    Route::get('/family-units', [FamilyUnitController::class, 'index'])->name('family_units.index');
    Route::get('/family-units/create', [FamilyUnitController::class, 'create'])->name('family_units.create');
    Route::get('/family-units/{id}', [FamilyUnitController::class, 'show'])->name('family_units.show');
    Route::get('/family-units/{id}/edit', [FamilyUnitController::class, 'edit'])->name('family_units.edit');
    Route::put('/family-units/{id}', [FamilyUnitController::class, 'update'])->name('family_units.update');
    Route::post('/family-units', [FamilyUnitController::class, 'store'])->name('family_units.store');

    // Member Routes
    Route::get('/family-units/{family_unit_id}/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::get('/members/{id}/', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.delete');

    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

    // Samurdhi Management
    Route::get('/samurdhi-payment-requests', [SamurdhiPaymentRequestController::class, 'index'])->name('samurdhi_payment_requests.index');
    Route::get('/samurdhi-payment-requests/create', [SamurdhiPaymentRequestController::class, 'create'])->name('samurdhi_payment_requests.create');
    Route::get('/samurdhi-payment-requests/{id}', [SamurdhiPaymentRequestController::class, 'show'])->name('samurdhi_payment_requests.show');
    Route::post('/samurdhi-payment-requests', [SamurdhiPaymentRequestController::class, 'store'])->name('samurdhi_payment_requests.store');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Settings Pages
    Route::get('/settings/wards', [PageController::class, 'showWardManage'])->name(('settings.wards'));
    Route::get('/settings/gn-divisions', [PageController::class, 'showGnDivisionManage'])->name(('settings.gnDivisions'));

    Route::post('/ward', [WardController::class, 'store'])->name(('ward'));
    Route::post('/gn-division', [GnDivisionController::class, 'store'])->name(('gnDivision'));
});