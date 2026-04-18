<?php

use App\Http\Controllers\Web\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
// Tambahkan sub-folder \Web\ pada semua controller
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ChildController;
use App\Http\Controllers\Web\GrowthRecordController;
use App\Http\Controllers\Web\FoodRecordController;

// Untuk folder Admin, tambahkan \Web\Admin\
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Web\Admin\ChildrenController as AdminChildren;
use App\Http\Controllers\Web\Admin\MonitoringController;
use App\Http\Controllers\Web\Admin\ReportController;

// Guest
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

// Auth
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/children', [AdminChildren::class, 'index']);
    Route::get('/admin/children/create', [AdminChildren::class, 'create']);
    Route::post('/admin/children', [AdminChildren::class, 'store']);
    Route::get('/admin/children/{id}/edit', [AdminChildren::class, 'edit']);
    Route::put('/admin/children/{id}', [AdminChildren::class, 'update']);
    Route::delete('/admin/children/{id}', [AdminChildren::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/monitoring', [MonitoringController::class, 'index']);
    Route::get('/admin/monitoring/{id}/edit', [MonitoringController::class, 'edit'])->name('admin.monitoring.edit');
    Route::put('/admin/monitoring/{id}', [MonitoringController::class, 'update'])->name('admin.monitoring.update');
    Route::get('/admin/monitoring/history/{child_id}', [MonitoringController::class, 'history'])->name('admin.monitoring.history');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/reports/food', [ReportController::class, 'foodReport'])->name('admin.reports.food');
    Route::get('/admin/reports/growth', [ReportController::class, 'growthReport'])->name('admin.reports.growth');
});

Route::middleware('auth')->group(function () {
    Route::get('/users/password', [ProfileController::class, 'index'])
        ->name('admin.users.password.index');

    // form edit password
    Route::get('/users/{id}/password/edit', [ProfileController::class, 'edit'])
        ->name('admin.users.password.edit');

    // update password
    Route::put('/users/{id}/password', [ProfileController::class, 'update'])
        ->name('admin.users.password.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/children', [ChildController::class, 'index']);
    Route::get('/children/create', [ChildController::class, 'create']);
    Route::post('/children', [ChildController::class, 'store']);
    Route::get('/children/{id}/edit', [ChildController::class, 'edit']);
    Route::put('/children/{id}', [ChildController::class, 'update']);
    Route::delete('/children/{id}', [ChildController::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/growth', [GrowthRecordController::class, 'index']);
    Route::get('/growth/create', [GrowthRecordController::class, 'create']);
    Route::post('/growth', [GrowthRecordController::class, 'store']);
    Route::get('/growth/{id}/edit', [GrowthRecordController::class, 'edit']);
    Route::put('/growth/{id}', [GrowthRecordController::class, 'update']);
    Route::get('/growth/history', [GrowthRecordController::class, 'history']);
    Route::delete('/growth/{id}', [GrowthRecordController::class, 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/food', [FoodRecordController::class, 'index']);
    Route::get('/food/create', [FoodRecordController::class, 'create']);
    Route::post('/food', [FoodRecordController::class, 'store']);
    Route::get('/food/{id}/edit', [FoodRecordController::class, 'edit']);
    Route::put('/food/{id}', [FoodRecordController::class, 'update']);
    Route::delete('/food/{id}', [FoodRecordController::class, 'destroy']);
});