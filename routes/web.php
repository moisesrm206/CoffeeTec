<?php

use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/menu', [ProductController::class, 'index'])->name('menu');

Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');

Route::middleware(['auth', 'role:admin,cocina'])->group(function (): void {
    Route::get('/cocina', [OrderController::class, 'index'])->name('kitchen');

    Route::post('/pedidos/{order}/estado', [OrderController::class, 'updateStatus'])->name('orders.status');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/personal', [StaffController::class, 'index'])->name('staff.index');
        Route::post('/personal', [StaffController::class, 'store'])->name('staff.store');
        Route::patch('/personal/{user}', [StaffController::class, 'update'])->name('staff.update');
        Route::delete('/personal/{user}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });

require __DIR__.'/auth.php';
