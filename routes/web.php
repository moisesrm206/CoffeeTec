<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/menu', [ProductController::class, 'index'])->name('menu');

Route::get('/cocina', [OrderController::class, 'index'])->name('kitchen');

Route::post('/pedidos', [OrderController::class, 'store'])->name('orders.store');
Route::post('/pedidos/{order}/estado', [OrderController::class, 'updateStatus'])->name('orders.status');
