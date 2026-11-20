<?php

use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/menu', [ProductController::class, 'index'])->name('menu');

Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
Route::get('/pedidos/{order}/seguimiento', [OrderController::class, 'track'])->name('orders.track');

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

        Route::get('/productos', [ProductController::class, 'adminIndex'])->name('products.index');
        Route::get('/productos/crear', [ProductController::class, 'create'])->name('products.create');
        Route::post('/productos', [ProductController::class, 'store'])->name('products.store');
        Route::get('/productos/{product}/editar', [ProductController::class, 'edit'])->name('products.edit');
        Route::patch('/productos/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/productos/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

require __DIR__.'/auth.php';
