@extends('templates.app')

@section('title', 'Seguimiento de pedido #{{ $order->id_order }} | CoffeeTec')

@section('content')
    <div class="max-w-2xl mx-auto py-8">
        <div class="bg-white rounded-xl shadow-sm border border-coffee-light/20 p-6 md:p-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-coffee-dark mb-1">Seguimiento de pedido</h1>
                    <p class="text-coffee-dark/60 text-sm">Orden #{{ str_pad($order->id_order, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
                <a href="{{ route('menu') }}"
                    class="inline-flex items-center gap-2 px-3 py-2 rounded-md border border-coffee-light/50 bg-white text-coffee-dark text-sm font-medium hover:bg-coffee-gold/50 hover:text-coffee-gold transition-colors">
                    ← Volver al menú
                </a>
            </div>

            <!-- Información del pedido -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-coffee-dark/5 rounded-lg p-4 border border-coffee-light/30">
                    <p class="text-xs font-medium text-coffee-dark/50 uppercase tracking-wider mb-1">Cliente</p>
                    <p class="text-lg font-semibold text-coffee-dark">{{ $order->customer ?? 'Cliente sin nombre' }}</p>
                </div>
                <div class="bg-coffee-dark/5 rounded-lg p-4 border border-coffee-light/30">
                    <p class="text-xs font-medium text-coffee-dark/50 uppercase tracking-wider mb-1">Estado</p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md {{ $current['color'] }} text-xs font-bold uppercase tracking-wider border">
                        {{ $current['label'] }}
                    </span>
                </div>
                <div class="bg-coffee-dark/5 rounded-lg p-4 border border-coffee-light/30">
                    <p class="text-xs font-medium text-coffee-dark/50 uppercase tracking-wider mb-1">Total</p>
                    <p class="text-lg font-bold text-coffee-dark">${{ number_format($order->total, 2) }}</p>
                </div>
            </div>

            <!-- Barra de progreso de estados -->
            <div class="mb-6">
                <p class="text-xs font-medium text-coffee-dark/50 uppercase tracking-wider mb-3">Estado del pedido</p>
                <div class="flex items-center gap-4">
                    @php
                        $steps = [
                            'pending' => 'Pendiente',
                            'making' => 'En preparación',
                            'completed' => 'Listo',
                            'delivered' => 'Entregado',
                        ];
                    @endphp
                    @foreach ($steps as $status => $label)
                        @php
                            $isActive = $order->status === $status;
                            $isCompleted = array_search($order->status, ['pending', 'making', 'completed', 'delivered']) >= array_search($status, ['pending', 'making', 'completed', 'delivered']);
                        @endphp
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center
                                @if ($isCompleted)
                                    bg-coffee-gold text-white border-2 border-coffee-gold
                                @else
                                    bg-coffee-light/20 text-coffee-dark/40 border border-coffee-light/30
                                @endif
                                shadow-sm">
                                <span class="text-xs font-bold">{{ $loop->iteration }}</span>
                            </div>
                            <span class="text-xs
                                @if ($isCompleted)
                                    text-coffee-dark font-semibold
                                @else
                                    text-coffee-dark/40
                                @endif">{{ $label }}</span>
                            @if (!$loop->last)
                                <div class="w-8 h-0.5
                                    @if ($isCompleted)
                                        bg-coffee-gold
                                    @else
                                        bg-coffee-light/30
                                    @endif"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Productos -->
            <div class="border border-coffee-light/20 rounded-lg overflow-hidden">
                <div class="bg-coffee-dark/5 px-4 py-3 border-b border-coffee-light/20">
                    <h2 class="text-sm font-semibold text-coffee-dark uppercase tracking-wider">Tu orden</h2>
                </div>
                <div class="divide-y divide-coffee-light/10">
                    @forelse ($order->orderProducts as $orderProduct)
                        <div class="px-4 py-4 flex justify-between items-center">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-coffee-dark">{{ $orderProduct->product->name }}</span>
                                <span class="text-xs text-coffee-dark/50">{{ $orderProduct->quantity }} × ${{ number_format($orderProduct->price, 2) }}</span>
                            </div>
                            <span class="text-sm font-medium text-coffee-dark">${{ number_format($orderProduct->price * $orderProduct->quantity, 2) }}</span>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <p class="text-coffee-dark/40 text-sm">No hay productos en este pedido.</p>
                        </div>
                    @endforelse
                </div>
                <div class="bg-white px-4 py-4 border-t border-coffee-light/20">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-coffee-dark">Total</span>
                        <span class="text-lg font-bold text-coffee-dark">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            @if ($order->status === 'cancelled')
                <div class="mt-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
                    Este pedido ha sido cancelado.
                </div>
            @elseif ($order->status === 'delivered')
                <div class="mt-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm">
                    ¡Tu pedido está listo! Puedes recogerlo en la cafetería.
                </div>
            @endif
        </div>
    </div>
@endsection
