<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::get('/menu', [ProductController::class, 'index'])->name('menu');

Route::get('/cocina', fn () => view('cocina', [
    'order' => session('order'),
]))->name('kitchen');

Route::post('/pedidos', function () {
    $items = json_decode(request('items', '[]'), true);

    if (! is_array($items) || count($items) === 0) {
        return back()->with('error', 'Agrega al menos un producto al pedido.');
    }

    $order = [
        'id' => 1,
        'customer' => request('customer'),
        'group' => request('group'),
        'items' => $items,
        'total' => collect($items)->sum(fn ($item) => $item['price'] * $item['quantity']),
        'status' => 'Pendiente',
    ];

    session(['order' => $order]);

    return redirect()->route('kitchen')->with('success', 'Pedido creado correctamente.');
})->name('orders.store');

Route::post('/pedidos/estado', function () {
    $order = session('order');

    if (! $order) {
        return redirect()->route('kitchen');
    }

    $order['status'] = request('status');
    session(['order' => $order]);

    return redirect()->route('kitchen')->with('success', 'Estado del pedido actualizado.');
})->name('orders.status');
