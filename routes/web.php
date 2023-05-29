<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyUnitController;
use App\Http\Controllers\GnDivisionController;
use App\Http\Controllers\MemberController;
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

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    
    Route::get('/family-units/{id}/create-member', [PageController::class, 'showCreateMember'])->name('familyUnit.createMember');

    // Settings Pages
    Route::get('/settings/wards', [PageController::class, 'showWardManage'])->name(('settings.wards'));
    Route::get('/settings/gn-divisions', [PageController::class, 'showGnDivisionManage'])->name(('settings.gnDivisions'));

    Route::post('/ward', [WardController::class, 'store'])->name(('ward'));
    Route::post('/gn-division', [GnDivisionController::class, 'store'])->name(('gnDivision'));
    // Route::post('/member', [MemberController::class, 'store'])->name('member.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Family Units
    Route::get('/family-units', [FamilyUnitController::class, 'index'])->name('family_units.index');
    Route::get('/family-units/create', [FamilyUnitController::class, 'create'])->name('family_units.create');
    Route::get('/family-units/{family_unit_id}/', [FamilyUnitController::class, 'show'])->name('family_units.show');
    
    // Member Routes
    Route::get('/family-units/{family_unit_id}/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::get('/members/{id}/', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{id}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.delete');
});