<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $orders = Order::query()
            ->with('orderProducts.product')
            ->latest('id_order')
            ->get();

        return view('cocina', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $customer = $request->string('customer')->trim()->toString();
        $items = json_decode($request->input('items', '[]'), true);

        if (
            $customer === ''
            || ! is_array($items)
            || count($items) === 0
            || ! collect($items)->every(fn (mixed $item): bool => is_array($item))
        ) {
            return back()->with('error', 'Agrega al menos un producto al pedido.');
        }

        $quantities = collect($items)->mapWithKeys(function (mixed $item): array {
            return [
                (int) ($item['id'] ?? 0) => (int) ($item['quantity'] ?? 0),
            ];
        });

        if ($quantities->contains(fn (int $quantity): bool => $quantity < 1)) {
            return back()->with('error', 'La cantidad de cada producto debe ser válida.');
        }

        $products = Product::query()
            ->whereIn('id_product', $quantities->keys())
            ->get()
            ->keyBy('id_product');

        if ($products->count() !== $quantities->count()) {
            return back()->with('error', 'Uno de los productos seleccionados ya no está disponible.');
        }

        $orderItems = $quantities->map(function (int $quantity, int $productId) use ($products): array {
            $product = $products->get($productId);

            return [
                'id' => $product->id_product,
                'name' => $product->name,
                'price' => (float) $product->price,
                'quantity' => $quantity,
            ];
        })->values();

        $total = $orderItems->sum(
            fn (array $item): float => $item['price'] * $item['quantity']
        );

        $order = DB::transaction(function () use ($orderItems, $total, $customer) {
            $order = Order::create([
                'customer' => $customer,
                'total' => $total,
                'status' => 'pending',
            ]);

            $order->orderProducts()->createMany(
                $orderItems->map(fn (array $item): array => [
                    'id_product' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ])->all()
            );

            return $order;
        });

        return redirect()->route('orders.track', $order)->with('success', 'Pedido creado correctamente.');
    }

    /**
     * Show the order tracking page for customers.
     */
    public function track(Order $order)
    {
        $statuses = [
            'pending' => ['label' => 'Pendiente', 'color' => 'bg-amber-100 text-amber-800 border-amber-200', 'step' => 1],
            'making' => ['label' => 'En preparación', 'color' => 'bg-blue-100 text-blue-800 border-blue-200', 'step' => 2],
            'completed' => ['label' => 'Listo para recoger', 'color' => 'bg-green-100 text-green-800 border-green-200', 'step' => 3],
            'delivered' => ['label' => 'Entregado', 'color' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'step' => 4],
            'cancelled' => ['label' => 'Cancelado', 'color' => 'bg-red-100 text-red-800 border-red-200', 'step' => 0],
        ];

        $current = $statuses[$order->status] ?? $statuses['pending'];

        return view('orders.track', [
            'order' => $order,
            'statuses' => $statuses,
            'current' => $current,
        ]);
    }

    /**
     * Update an order status.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['making', 'completed'])],
        ]);

        $order->update($validated);

        return redirect()->route('kitchen')->with('success', 'Estado del pedido actualizado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
