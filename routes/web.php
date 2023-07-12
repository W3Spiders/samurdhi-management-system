<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElderAllowancePaymentRequestController;
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
Route::middleware('guest')->group(function () {
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
    Route::delete('/family-units/{id}', [FamilyUnitController::class, 'destroy'])->name('family_units.delete');

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
    Route::get('/samurdhi-payment-requests/{id}/edit', [SamurdhiPaymentRequestController::class, 'edit'])->name('samurdhi_payment_requests.edit');
    Route::put('/samurdhi-payment-requests/{id}', [SamurdhiPaymentRequestController::class, 'update'])->name('samurdhi_payment_requests.update');
    Route::post('/samurdhi-payment-requests', [SamurdhiPaymentRequestController::class, 'store'])->name('samurdhi_payment_requests.store');
    Route::get('/samurdhi-payment-requests/download_payment_list/{id}', [SamurdhiPaymentRequestController::class, 'export_payment_list'])->name('samurdhi_payment_requests.export_payment_list');
    Route::get('/samurdhi-payment-requests/print_payment_list/{id}', [SamurdhiPaymentRequestController::class, 'print_payment_list'])->name('samurdhi_payment_requests.print_payment_list');

    // Elder Allowance Management
    Route::get('/elder-allowance-payment-requests', [ElderAllowancePaymentRequestController::class, 'index'])->name('elder_allowance_payment_requests.index');
    Route::get('/elder-allowance-payment-requests/create', [ElderAllowancePaymentRequestController::class, 'create'])->name('elder_allowance_payment_requests.create');
    Route::get('/elder-allowance-payment-requests/{id}', [ElderAllowancePaymentRequestController::class, 'show'])->name('elder_allowance_payment_requests.show');
    Route::get('/elder-allowance-payment-requests/{id}/edit', [ElderAllowancePaymentRequestController::class, 'edit'])->name('elder_allowance_payment_requests.edit');
    Route::put('/elder-allowance-payment-requests/{id}', [ElderAllowancePaymentRequestController::class, 'update'])->name('elder_allowance_payment_requests.update');
    Route::post('/elder-allowance-payment-requests', [ElderAllowancePaymentRequestController::class, 'store'])->name('elder_allowance_payment_requests.store');
    Route::get('/elder-allowance-payment-requests/download_payment_list/{id}', [ElderAllowancePaymentRequestController::class, 'export_payment_list'])->name('elder_allowance_payment_requests.export_payment_list');
    Route::get('/elder-allowance-payment-requests/print_payment_list/{id}', [ElderAllowancePaymentRequestController::class, 'print_payment_list'])->name('elder_allowance_payment_requests.print_payment_list');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    // GN Divisions
    Route::get('/gn-divisions', [GnDivisionController::class, 'index'])->name(('gn_divisions.index'));
    Route::get('/gn-divisions/create', [GnDivisionController::class, 'create'])->name(('gn_divisions.create'));
    Route::get('/gn-divisions/{id}', [GnDivisionController::class, 'show'])->name(('gn_divisions.show'));
    Route::post('/gn_divisions', [GnDivisionController::class, 'store'])->name('gn_divisions.store');
    Route::get('/gn-divisions/{id}/edit', [GnDivisionController::class, 'edit'])->name(('gn_divisions.edit'));
    Route::put('/gn-divisions/{id}', [GnDivisionController::class, 'update'])->name(('gn_divisions.update'));
    Route::delete('/gn-divisions/{id}', [GnDivisionController::class, 'destroy'])->name('gn_divisions.delete');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Settings Pages
    Route::get('/settings/wards', [PageController::class, 'showWardManage'])->name(('settings.wards'));
    Route::get('/settings/gn-divisions', [PageController::class, 'showGnDivisionManage'])->name(('settings.gnDivisions'));

    Route::post('/ward', [WardController::class, 'store'])->name(('ward'));
});